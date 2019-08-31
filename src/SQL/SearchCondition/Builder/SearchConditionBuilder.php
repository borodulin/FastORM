<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\Driver\DriverAwareInterface;
use FastOrm\Driver\DriverAwareTrait;
use FastOrm\SQL\BuilderInterface;
use FastOrm\SQL\SearchCondition\Operator\NotOperatorInterface;
use FastOrm\SQL\SearchCondition\SearchCondition;

class SearchConditionBuilder implements BuilderInterface, DriverAwareInterface
{
    use DriverAwareTrait;

    /**
     * @var SearchCondition
     */
    private $condition;

    public function __construct(SearchCondition $condition)
    {
        $this->condition = $condition;
    }

    public function getText(): string
    {
        if (!$operator = $this->condition->getOperator()) {
            return '';
        }
        $text = '';
        if ($operator instanceof NotOperatorInterface) {
            $operator->setNot($this->condition->isNot());
        } else {
            $text = $this->condition->isNot() ? 'NOT ' : '';
        }
        return $text .  $this->driver->buildExpression($operator);
    }
}
