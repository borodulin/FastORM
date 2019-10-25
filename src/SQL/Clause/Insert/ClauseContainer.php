<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Insert;

use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\HasStatementTrait;
use FastOrm\SQL\Clause\InsertClauseInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class ClauseContainer implements
    InsertClauseInterface,
    ColumnsClauseInterface,
    ValuesClauseInterface,
    LoggerAwareInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use LoggerAwareTrait;
    use CompilerAwareTrait;
    use HasStatementTrait;

    private $table;
    /**
     * @var array
     */
    private $columns = [];
    private $values = [];

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function into($table): ColumnsClauseInterface
    {
        $this->table = $table;
        return $this;
    }

    public function columns(array $columns): ValuesClauseInterface
    {
        $this->columns = $columns;
        return $this;
    }

    public function values($values): ValuesClauseInterface
    {
        $this->values[] = $values;
        return $this;
    }

    public function __toString()
    {
        try {
            $compiler = $this->connection->getDriver()->createCompiler();
            return $compiler->compile($this);
        } catch (Throwable $exception) {
            $this->logger && $this->logger->error($exception);
            return '';
        }
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof ClauseContainer) {
            throw new InvalidArgumentException();
        }
        if ($this->table instanceof ExpressionInterface) {
            $table = $this->compiler->compile($this->table);
        } elseif (is_string($this->table)) {
            $table = $this->compiler->quoteTableName($this->table);
        } else {
            throw new InvalidArgumentException();
        }
        $columns = $this->processColumns();
        $values = $this->processValues();
        $values = $values ? " VALUES {$values}" : '';
        return "INSERT INTO {$table}{$columns}{$values}";
    }

    protected function processColumns()
    {
        $columns = [];
        $values = [];
        foreach ($this->columns as $key => $column) {
            if (is_int($key)) {
                if ($column instanceof ExpressionInterface) {
                    $column = $this->compiler->compile($column);
                } else {
                    $column = $this->compiler->quoteColumnName($column);
                }
            } elseif (is_string($key)) {
                $key = $this->compiler->quoteColumnName($key);
                $values[$key] = $column;
                $column = $key;
            }
            $columns[] = $column;
        }
        if ($values) {
            $this->values[] = $values;
        }
        $this->columns = $columns;
        $columns = implode(',', $columns);
        return $columns ? " ($columns)" : '';
    }

    protected function processValues()
    {
        $params = $this->compiler->getParams();
        $values = [];
        foreach ($this->values as $row) {
            if ($row instanceof ExpressionInterface) {
                $row = $this->compiler->compile($row);
                $values[] = "($row)";
            } elseif (is_array($row)) {
                $string = [];
                foreach ($row as $key => $value) {
                    if ($value instanceof ExpressionInterface) {
                        $value = $this->compiler->compile($value);
                    } else {
                        $value = ':' . $params->bindValue($value);
                    }
                    $string[$key] = $value;
                }
                $values[] = '(' . implode(',', $string) . ')';
            } else {
                throw new InvalidArgumentException();
            }
        }
        return implode(',', $values);
    }

    public function __clone()
    {
        $this->values = [];
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @throws DbException
     * @since 5.1.0
     */
    public function count()
    {
        return $this->execute();
    }

    /**
     * @param array $params
     * @return int
     * @throws DbException
     */
    public function execute(array $params = []): int
    {
        return $this->statement()->execute($params)->rowCount();
    }
}
