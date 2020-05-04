<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Operator\Builder\LikeOperatorBuilder;
use FastOrm\SQL\Clause\Operator\LikeOperator;
use FastOrm\SQL\Clause\Select\Builder\FromClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\GroupByClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\JoinClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\LimitClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\OrderByClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\SelectClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\UnionClauseBuilder;
use FastOrm\SQL\Clause\Select\FromClause;
use FastOrm\SQL\Clause\Select\GroupByClause;
use FastOrm\SQL\Clause\Select\JoinClause;
use FastOrm\SQL\Clause\Select\LimitClause;
use FastOrm\SQL\Clause\Select\OrderByClause;
use FastOrm\SQL\Clause\Select\SelectClause;
use FastOrm\SQL\Clause\Select\UnionClause;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Compiler implements CompilerInterface
{
    use LoggerAwareTrait;
    use EventDispatcherAwareTrait;

    protected $quoteColumnChar = '';
    protected $quoteTableChar = '';

    protected static $defaultClassMap = [
        SelectClause::class => SelectClauseBuilder::class,
        FromClause::class => FromClauseBuilder::class,
        JoinClause::class => JoinClauseBuilder::class,
        GroupByClause::class => GroupByClauseBuilder::class,
        UnionClause::class => UnionClauseBuilder::class,
        OrderByClause::class => OrderByClauseBuilder::class,
        LimitClause::class => LimitClauseBuilder::class,

        LikeOperator::class => LikeOperatorBuilder::class,

        Expression::class => ExpressionBuilder::class,
    ];
    /**
     * @var array
     */
    private $classMap;
    /**
     * @var Params
     */
    private $params;

    public function __construct(array $classMap = [])
    {
        $this->classMap = $classMap ? array_replace(static::$defaultClassMap, $classMap) : static::$defaultClassMap;
        $this->params = new Params();
    }

    public function compile(ExpressionInterface $expression): string
    {
        $classBuilder = $this->classMap[\get_class($expression)] ?? null;
        if ($classBuilder) {
            $instance = new $classBuilder();
            if (!$instance instanceof ExpressionBuilderInterface) {
                throw new InvalidArgumentException();
            }
        } elseif ($expression instanceof ExpressionBuilderInterface) {
            $instance = $expression;
        } else {
            throw new InvalidArgumentException();
        }
        if ($instance instanceof CompilerAwareInterface) {
            $instance->setCompiler($this);
        }
        if ($this->logger && $instance instanceof LoggerAwareInterface) {
            $instance->setLogger($this->logger);
        }

        return $instance->build($expression);
    }

    public function quoteColumnName(string $name): string
    {
        if ($this->quoteColumnChar) {
            if (preg_match('/^([\w]+)(?i:\.)([\w*]+)$/', $name, $matches)) {
                return $this->quoteName($matches[1], $this->quoteColumnChar).'.'
                    .(('*' === $matches[2]) ? $matches[2] : $this->quoteName($matches[2], $this->quoteColumnChar));
            } else {
                return $this->quoteName($name, $this->quoteColumnChar);
            }
        }

        return $name;
    }

    public function quoteTableName(string $name): string
    {
        return  $this->quoteTableChar ? $this->quoteName($name, $this->quoteTableChar) : $name;
    }

    public function getParams(): ParamsInterface
    {
        return $this->params;
    }

    protected function quoteName($name, $quoteChar)
    {
        return $quoteChar.trim($name, $quoteChar).$quoteChar;
    }
}
