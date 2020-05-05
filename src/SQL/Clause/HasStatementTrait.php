<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\ConnectionInterface;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\PdoCommand\Statement;
use Borodulin\ORM\PdoCommand\StatementInterface;
use Borodulin\ORM\SQL\Compiler;
use Borodulin\ORM\SQL\ExpressionInterface;

trait HasStatementTrait
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
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
