<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\QueryDecoratorTrait;
use FastOrm\SQL\QueryInterface;
use SplStack;

class Compound implements CompoundInterface
{
    use QueryDecoratorTrait;
    /**
     * @var SplStack
     */
    private $compounds;

    public function __construct(QueryInterface $query)
    {
        $this->compounds = new SplStack();
        $this->compounds->add(0, new CompoundItem(new SearchCondition($this), ''));
        $this->query = $query;
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
