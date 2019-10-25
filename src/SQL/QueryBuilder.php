<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\DeleteClauseInterface;
use FastOrm\SQL\Clause\DeleteQuery;
use FastOrm\SQL\Clause\InsertClauseInterface;
use FastOrm\SQL\Clause\InsertQuery;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\UpdateClauseInterface;
use FastOrm\SQL\Clause\UpdateQuery;

class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function select(): SelectClauseInterface
    {
        return new SelectQuery($this->connection);
    }

    public function update(): UpdateClauseInterface
    {
        return new UpdateQuery($this->connection);
    }

    public function insert(): InsertClauseInterface
    {
        return new InsertQuery($this->connection);
    }

    public function delete(): DeleteClauseInterface
    {
        return new DeleteQuery($this->connection);
    }
}
