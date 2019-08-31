<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\Driver\DriverAwareInterface;
use FastOrm\Driver\DriverAwareTrait;
use FastOrm\SQL\BuilderInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundItem;

class CompoundBuilder implements BuilderInterface, DriverAwareInterface
{
    use DriverAwareTrait;

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
            if ($text = $this->driver->buildExpression($searchCondition)) {
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
