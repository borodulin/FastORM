<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Operator\OperatorInterface;

class SearchCondition implements ExpressionInterface
{
    /**
     * @var bool
     */
    private $not = false;
    /**
     * @var OperatorInterface
     */
    private $operator;
    /**
     * @var Compound
     */
    private $compound;

    public function __construct(Compound $compound)
    {
        $this->compound = $compound;
    }

    public function not(): void
    {
        $this->not = true;
    }

    public function setOperator(OperatorInterface $operator): void
    {
        $this->operator = $operator;
    }

    /**
     * @return OperatorInterface
     */
    public function getOperator(): ?OperatorInterface
    {
        return $this->operator;
    }

    /**
     * @return bool
     */
    public function isNot(): bool
    {
        return $this->not;
    }

    /**
     * @return Compound
     */
    public function getCompound(): Compound
    {
        return $this->compound;
    }
}
