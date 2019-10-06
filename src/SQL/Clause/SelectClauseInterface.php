<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\PdoCommand\Fetch\IteratorFactoryInterface;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\Select\FromClauseInterface;
use FastOrm\SQL\Clause\Select\OffsetClauseInterface;
use FastOrm\SQL\Clause\Select\SelectDistinctInterface;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\ConditionInterface;

interface SelectClauseInterface extends ExpressionInterface, ContextInterface
{
    public function select($columns): SelectDistinctInterface;

    public function from($from): FromClauseInterface;

    public function groupBy($columns): SelectClauseInterface;

    public function having(): ConditionInterface;

    public function limit(int $limit): OffsetClauseInterface;

    public function orderBy($columns): SelectClauseInterface;

    public function union(SelectClauseInterface $query): SelectClauseInterface;

    public function unionAll(SelectClauseInterface $query): SelectClauseInterface;

    public function where(): ConditionInterface;

    public function statement(array $options = []): StatementInterface;

    public function fetch(array $params = []): FetchInterface;

    public function setIteratorFactory(IteratorFactoryInterface $factory): SelectClauseInterface;
}
