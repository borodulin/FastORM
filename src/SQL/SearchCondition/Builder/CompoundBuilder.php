<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\ConnectionAwareInterface;
use FastOrm\ConnectionAwareTrait;
use FastOrm\SQL\BuilderInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundItem;

class CompoundBuilder implements BuilderInterface, ConnectionAwareInterface
{
    use ConnectionAwareTrait;

    /**
     * @var Compound
     */
    private $compound;

    public function __construct(Compound $compound)
    {
        $this->compound = $compound;
    }

    public function getText(): string
    {
        $conditions = [];
        /** @var CompoundItem $compoundItem */
        foreach ($this->compound->getCompounds() as $compoundItem) {
            $searchCondition = $compoundItem->getSearchCondition();
            if ($text = $this->connection->buildExpression($searchCondition)) {
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
