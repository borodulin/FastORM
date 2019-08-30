<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\ExpressionInterface;
use SplStack;

class Compound implements ExpressionInterface
{
    /**
     * @var SplStack
     */
    private $compounds;
    /**
     * @var CompoundInterface
     */
    private $compound;

    public function __construct(CompoundInterface $compound)
    {
        $this->compounds = new SplStack();
        $this->compounds->push(new CompoundItem(new SearchCondition($compound), 'AND'));
        $this->compound = $compound;
    }

    public function and(): SearchConditionInterface
    {
        $searchCondition = new SearchCondition($this->compound);
        $this->compounds->push(new CompoundItem($searchCondition, 'AND'));
        return $searchCondition;
    }

    public function or(): SearchConditionInterface
    {
        $searchCondition = new SearchCondition($this->compound);
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
