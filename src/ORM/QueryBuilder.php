<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\Delete\WhereClauseInterface;
use FastOrm\SQL\Clause\DeleteQuery;
use FastOrm\SQL\Clause\Insert\ColumnsClauseInterface;
use FastOrm\SQL\Clause\InsertQuery;
use FastOrm\SQL\Clause\Select\SelectDistinctInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\UpdateClauseInterface;
use FastOrm\SQL\Clause\UpdateQuery;

class QueryBuilder
{
    /**
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var string
     */
    private $entityClass;
    /**
     * @var string
     */
    private $tableName;

    /**
     * QueryBuilder constructor.
     *
     * @param $tableName
     */
    public function __construct(
        ConnectionInterface $connection,
        string $entityClass,
        $tableName
    ) {
        $this->connection = $connection;
        $this->entityClass = $entityClass;
        $this->tableName = $tableName;
    }

    public function select($columns = []): SelectDistinctInterface
    {
        return (new SelectQuery($this->connection))
            ->from($this->tableName)
            ->select($columns);
    }

    public function update(): UpdateClauseInterface
    {
        return (new UpdateQuery($this->connection))
            ->update($this->tableName);
    }

    public function insert(): ColumnsClauseInterface
    {
        return (new InsertQuery($this->connection))
            ->into($this->tableName);
    }

    public function delete(): WhereClauseInterface
    {
        return (new DeleteQuery($this->connection))
            ->from($this->tableName);
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }
}
