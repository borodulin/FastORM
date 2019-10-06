<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\Delete\DeleteClauseInterface;
use FastOrm\SQL\Clause\Insert\InsertClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\Update\UpdateClauseInterface;
use FastOrm\SQL\QueryBuilderInterface;

class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;
    private $tableName;

    public function __construct(ConnectionInterface $connection, $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    public function select(): SelectClauseInterface
    {
        return (new SelectQuery($this->connection))->from($this->tableName);
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
