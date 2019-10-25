<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\Delete\WhereClauseInterface;
use FastOrm\SQL\Clause\DeleteQuery;
use FastOrm\SQL\Clause\Insert\ColumnsClauseInterface;
use FastOrm\SQL\Clause\InsertQuery;
use FastOrm\SQL\Clause\Select\SelectDistinctInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\Update\SetClauseInterface;
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

    public function select($columns = []): SelectDistinctInterface
    {
        return (new SelectQuery($this->connection))->select($columns);
    }

    public function update($table): SetClauseInterface
    {
        return (new UpdateQuery($this->connection))->update($table);
    }

    public function insertInto($table): ColumnsClauseInterface
    {
        return (new InsertQuery($this->connection))->into($table);
    }

    public function deleteFrom($table): WhereClauseInterface
    {
        return (new DeleteQuery($this->connection))->from($table);
    }
}
