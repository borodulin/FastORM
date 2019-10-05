<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\SearchCondition\CompoundInterface;

interface OperatorListInterface
{
    public function between($column, $intervalStart, $intervalEnd): CompoundInterface;

    public function betweenColumns($value, $intervalStartColumn, $intervalEndColumn): CompoundInterface;

    public function exists(SelectClauseInterface $query): CompoundInterface;

    public function in($column, $values): CompoundInterface;

    public function like($column, $values): CompoundInterface;

    public function compare($column, $operator, $value): CompoundInterface;

    public function equal($column, $value): CompoundInterface;

    public function expression($expression, array $params = []): CompoundInterface;

    public function filterHashCondition(array $hash): CompoundInterface;

    public function hashCondition(array $hash): CompoundInterface;
}
