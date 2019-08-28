<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

use FastOrm\SQL\QueryInterface;

interface OperatorListInterface
{
    public function between($column, $intervalStart, $intervalEnd): CompoundInterface;

    public function betweenColumns($value, $intervalStartColumn, $intervalEndColumn): CompoundInterface;

    public function exists(QueryInterface $query): CompoundInterface;

    public function in($column, $values): CompoundInterface;

    public function like($column, $values): CompoundInterface;

    public function compare($column, $operator, $value): CompoundInterface;

    public function equal($column, $value): CompoundInterface;

    public function expression($expression, array $params = []): CompoundInterface;

    public function filterHashCondition(array $hash): CompoundInterface;

    public function hashCondition(array $hash): CompoundInterface;
}
