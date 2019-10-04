<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\PdoCommand\Fetch\IteratorFactoryInterface;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\Select\FromClauseInterface;
use FastOrm\SQL\Clause\Select\OffsetClauseInterface;
use FastOrm\SQL\Clause\Select\SelectClauseInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\ConditionInterface;

interface SelectInterface extends ExpressionInterface
{
    public function select($columns): SelectClauseInterface;

    public function from($from): FromClauseInterface;

    public function groupBy($columns): SelectInterface;

    public function having(): ConditionInterface;

    public function limit(int $limit): OffsetClauseInterface;

    public function orderBy($columns): SelectInterface;

    public function union(SelectInterface $query): SelectInterface;

    public function unionAll(SelectInterface $query): SelectInterface;

    public function where(): ConditionInterface;

    public function statement(array $options = []): StatementInterface;

    public function fetch(array $params = []): FetchInterface;

    public function setIteratorFactory(IteratorFactoryInterface $factory): SelectInterface;
}
