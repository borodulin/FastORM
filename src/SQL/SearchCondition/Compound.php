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
        $this->compounds->push(new CompoundItem(new SearchCondition($this), 'AND'));
        $this->query = $query;
    }

    public function and(): SearchConditionInterface
    {
        $searchCondition = new SearchCondition($this);
        $this->compounds->push(new CompoundItem($searchCondition, 'AND'));
        return $searchCondition;
    }

    public function or(): SearchConditionInterface
    {
        $searchCondition = new SearchCondition($this);
        $this->compounds->push(new CompoundItem($searchCondition, 'OR'));
        return $searchCondition;
    }

    public function getSearchCondition(): SearchConditionInterface
    {
        /** @var CompoundItem $compoundItem */
        $compoundItem = $this->compounds->top();
        return $compoundItem->getSearchCondition();
    }

    /**
     * @return SplStack
     */
    public function getCompounds(): SplStack
    {
        return $this->compounds;
    }
}
