<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\CommandInterface;
use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\AliasClauseInterface;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\OnClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;

interface QueryInterface extends ExpressionInterface
{
    public function select($columns): SelectClauseInterface;

    public function from($from): AliasClauseInterface;

    public function join($join, string $joinType = 'inner join'): OnClauseInterface;

    public function innerJoin($join): OnClauseInterface;

    public function leftJoin($join): OnClauseInterface;

    public function rightJoin($join): OnClauseInterface;

    public function fullJoin($join): OnClauseInterface;

    public function groupBy($columns): self;

    public function having(): SearchConditionInterface;

    public function limit(int $limit): OffsetClauseInterface;

    public function orderBy($columns): self;

    public function union(QueryInterface $query): self;

    public function unionAll(QueryInterface $query): self;

    public function where(): SearchConditionInterface;

    public function prepare(ConnectionInterface $connection): CommandInterface;
}
