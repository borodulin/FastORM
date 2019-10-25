<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Statement;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\ExpressionInterface;

trait HasStatementTrait
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @param array $options
     * @return StatementInterface
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        /** @var Compiler $compiler */
        $compiler = $this->connection->getDriver()->createCompiler();
        /** @var ExpressionInterface $this */
        $sql = $compiler->compile($this);
        $statement = new Statement($this->connection->getPdo(), $sql, $options);
        $statement->prepare($compiler->getParams());
        return $statement;
    }
}
