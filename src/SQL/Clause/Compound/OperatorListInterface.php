<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Compound;

use Borodulin\ORM\SQL\Clause\SelectClauseInterface;

interface OperatorListInterface
{
    public function between(string $column, $intervalStart, $intervalEnd): CompoundInterface;

    public function betweenColumns($value, string $intervalStartColumn, string $intervalEndColumn): CompoundInterface;

    public function exists(SelectClauseInterface $query): CompoundInterface;

    public function in(string $column, $values): CompoundInterface;

    public function like(string $column, $values): CompoundInterface;

    public function compare(string $column, string $operator, $value): CompoundInterface;

    public function compareColumns(string $column1, string $operator, string $column2): CompoundInterface;

    public function equal(string $column, $value): CompoundInterface;

    public function expression($expression, array $params = []): CompoundInterface;

    public function filterHashCondition(array $hash): CompoundInterface;

    public function hashCondition(array $hash): CompoundInterface;
}
