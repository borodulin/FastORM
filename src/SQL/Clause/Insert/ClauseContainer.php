<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Insert;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\InsertClauseInterface;

class ClauseContainer implements
    InsertClauseInterface,
    ColumnsClauseInterface,
    ValuesClauseInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function into($table): ColumnsClauseInterface
    {
        return $this;
    }

    public function columns(array $columns): ValuesClauseInterface
    {
        return $this;
    }

    public function values($values): ValuesClauseInterface
    {
        return $this;
    }
}
