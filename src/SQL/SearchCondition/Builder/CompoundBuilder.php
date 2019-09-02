<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundItem;

class CompoundBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof Compound) {
            throw new InvalidArgumentException();
        }
        $conditions = [];
        /** @var CompoundItem $compoundItem */
        foreach ($expression->getCompounds() as $compoundItem) {
            $searchCondition = $compoundItem->getSearchCondition();
            if ($text = $this->expressionBuilder->build($searchCondition)) {
                $conditions[$compoundItem->getCompound()][] = $text;
            }
        }
        $result = [];
        foreach ($conditions as $compound => $pieces) {
            $result[] = implode(" $compound ", $pieces);
        }
        return implode(' AND ', $result);
    }
}
