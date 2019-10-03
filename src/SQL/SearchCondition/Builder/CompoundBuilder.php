<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundItem;

class CompoundBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof Compound) {
            throw new InvalidArgumentException();
        }
        $conditions = [];
        /** @var CompoundItem $compoundItem */
        foreach ($expression->getCompounds() as $compoundItem) {
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
