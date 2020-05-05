<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL;

use Borodulin\ORM\ConnectionInterface;
use Borodulin\ORM\SQL\Clause\Delete\WhereClauseInterface;
use Borodulin\ORM\SQL\Clause\DeleteQuery;
use Borodulin\ORM\SQL\Clause\Insert\ColumnsClauseInterface;
use Borodulin\ORM\SQL\Clause\InsertQuery;
use Borodulin\ORM\SQL\Clause\Select\SelectDistinctInterface;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Clause\UpdateClauseInterface;
use Borodulin\ORM\SQL\Clause\UpdateQuery;

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

    public function update($table): UpdateClauseInterface
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
