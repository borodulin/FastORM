<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\Driver\CommandFetchInterface;
use FastOrm\SQL\Clause\AliasClauseInterface;
use FastOrm\SQL\Clause\OnClauseInterface;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Expression\SearchExpressionInterface;

interface QueryInterface
{
    public function select($columns): SelectClauseInterface;

    public function from($from): AliasClauseInterface;

    public function join($join, string $joinType = 'inner join'): OnClauseInterface;

    public function innerJoin($join): OnClauseInterface;

    public function leftJoin($join): OnClauseInterface;

    public function rightJoin($join): OnClauseInterface;

    public function fullJoin($join): OnClauseInterface;

    public function groupBy($columns): self;

    public function having(): SearchExpressionInterface;

    public function limit(int $limit): OffsetClauseInterface;

    public function orderBy($columns): self;

    public function union(QueryInterface $query): self;

    public function unionAll(QueryInterface $query): self;

    public function where(): SearchExpressionInterface;

    public function prepare(ConnectionInterface $connection, array $params = []): CommandFetchInterface;
}
