<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundItem;

class CompoundBuilder implements ExpressionInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var Compound
     */
    private $compound;

    public function __construct(Compound $compound)
    {
        $this->compound = $compound;
    }

    public function __toString(): string
    {
        $conditions = [];
        /** @var CompoundItem $compoundItem */
        foreach ($this->compound->getCompounds() as $compoundItem) {
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
}
