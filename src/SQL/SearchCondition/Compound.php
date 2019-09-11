<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\Clause\AbstractClause;
use FastOrm\SQL\Query;
use SplStack;

class Compound extends AbstractClause implements CompoundInterface
{
    /**
     * @var SplStack
     */
    private $compounds;

    public function __construct(Query $query)
    {
        parent::__construct($query);
        $this->compounds = new SplStack();
        $this->compounds->add(0, new CompoundItem(new SearchCondition($this), ''));
    }

    public function and(): ConditionInterface
    {
        $searchCondition = new SearchCondition($this);
        $this->compounds->add(0, new CompoundItem($searchCondition, 'AND'));
        return $searchCondition;
    }

    public function or(): ConditionInterface
    {
        $searchCondition = new SearchCondition($this);
        $this->compounds->add(0, new CompoundItem($searchCondition, 'OR'));
        return $searchCondition;
    }

    public function getCondition(): ConditionInterface
    {
        /** @var CompoundItem $compoundItem */
        $compoundItem = $this->compounds->top();
        return $compoundItem->getCondition();
    }

    /**
     * @return SplStack
     */
    public function getCompounds(): SplStack
    {
        return $this->compounds;
    }
}
