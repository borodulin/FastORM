<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\PdoCommand\Fetch\FetchInterface;
use Borodulin\ORM\SQL\Clause\Select\ConditionInterface;
use Borodulin\ORM\SQL\Clause\Select\FromClauseInterface;
use Borodulin\ORM\SQL\Clause\Select\OffsetClauseInterface;
use Borodulin\ORM\SQL\Clause\Select\SelectDistinctInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
use Countable;
use IteratorAggregate;

interface SelectClauseInterface extends
    IteratorAggregate,
    Countable,
    ExpressionInterface,
    HasStatementInterface
{
    public function select($columns): SelectDistinctInterface;

    public function from($from): FromClauseInterface;

    public function groupBy($columns): self;

    public function having(): ConditionInterface;

    public function limit(int $limit): OffsetClauseInterface;

    public function orderBy($columns): self;

    public function union(self $query): self;

    public function unionAll(self $query): self;

    public function where(): ConditionInterface;

    public function fetch(array $params = []): FetchInterface;

    public function toArray(): array;
}
