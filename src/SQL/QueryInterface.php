<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\CommandInterface;
use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\FromClauseInterface;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;

interface QueryInterface extends ExpressionInterface
{
    public function select($columns): SelectClauseInterface;

    public function from($from): FromClauseInterface;

    public function groupBy($columns): QueryInterface;

    public function having(): SearchConditionInterface;

    public function limit(int $limit): OffsetClauseInterface;

    public function orderBy($columns): QueryInterface;

    public function union(QueryInterface $query): QueryInterface;

    public function unionAll(QueryInterface $query): QueryInterface;

    public function where(): SearchConditionInterface;

    public function prepare(ConnectionInterface $connection): CommandInterface;
}
