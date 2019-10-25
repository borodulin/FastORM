<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use Countable;
use FastOrm\PdoCommand\Fetch\CursorFactoryInterface;
use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\SQL\Clause\Select\ConditionInterface;
use FastOrm\SQL\Clause\Select\FromClauseInterface;
use FastOrm\SQL\Clause\Select\OffsetClauseInterface;
use FastOrm\SQL\Clause\Select\SelectDistinctInterface;
use FastOrm\SQL\ExpressionInterface;
use IteratorAggregate;

interface SelectClauseInterface extends
    IteratorAggregate,
    Countable,
    ExpressionInterface,
    HasStatementInterface
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

    public function fetch(array $params = []): FetchInterface;

    public function setCursorFactory(CursorFactoryInterface $factory): SelectClauseInterface;

    public function toArray(): array;
}
