<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\ClauseContainer;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use SplStack;

class Compound implements
    ExpressionInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;
    /**
     * @var SplStack
     */
    private $compounds;
    /**
     * @var ClauseContainer
     */
    private $container;

    public function __construct(ClauseContainer $container)
    {
        $this->compounds = new SplStack();
        $this->container = $container;
    }

    public function and(): void
    {
        $searchCondition = new SearchCondition($this);
        $this->compounds->add(0, new CompoundItem($searchCondition, 'AND'));
    }

    public function or(): void
    {
        $searchCondition = new SearchCondition($this);
        $this->compounds->add(0, new CompoundItem($searchCondition, 'OR'));
    }

    public function getCondition(): SearchCondition
    {
        if ($this->compounds->count() === 0) {
            $this->compounds->add(0, new CompoundItem(new SearchCondition($this), ''));
        }
        /** @var CompoundItem $compoundItem */
        $compoundItem = $this->compounds->bottom();
        return $compoundItem->getCondition();
    }

    /**
     * @return SplStack
     */
    public function getCompounds(): SplStack
    {
        return $this->compounds;
    }

    /**
     * @return ClauseContainer
     */
    public function getContainer(): ClauseContainer
    {
        return $this->container;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof Compound) {
            throw new InvalidArgumentException();
        }
        $conditions = [];
        $compounds = $expression->getCompounds();
        $compounds->rewind();
        /** @var CompoundItem $compoundItem */
        foreach ($compounds as $compoundItem) {
            $searchCondition = $compoundItem->getCondition();
            if ($text = $this->compiler->compile($searchCondition)) {
                if ($compound = $compoundItem->getCompound()) {
                    $conditions[] = $compound;
                }
                $conditions[] = $text;
            }
        }
        return $conditions ? ' (' . implode(' ', $conditions) . ') ' : '';
    }

    public function __clone()
    {
        $this->compounds = clone $this->compounds;
    }
}
