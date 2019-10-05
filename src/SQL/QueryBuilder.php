<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\Delete\DeleteClauseInterface;
use FastOrm\SQL\Clause\Insert\InsertClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\Update\UpdateClauseInterface;

class QueryBuilder implements QueryInterface
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
        // TODO: Implement update() method.
    }

    public function insert(): InsertClauseInterface
    {
        // TODO: Implement insert() method.
    }

    public function delete(): DeleteClauseInterface
    {
        // TODO: Implement delete() method.
    }
}
