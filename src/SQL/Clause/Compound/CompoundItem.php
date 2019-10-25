<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Compound;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Operator\ExpressionOperator;
use FastOrm\SQL\Clause\Operator\NotOperatorInterface;
use FastOrm\SQL\Clause\Operator\OperatorInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class CompoundItem implements
    ExpressionInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

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
    /**
     * @var string
     */
    private $compoundString;

    public function __construct(Compound $compound, string $compoundString)
    {
        $this->compound = $compound;
        $this->compoundString = $compoundString;
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
     * @return CompoundItem
     */
    public function not(): self
    {
        $this->not = true;
        return $this;
    }

    /**
     * @param OperatorInterface $operator
     * @return CompoundItem
     */
    public function setOperator(OperatorInterface $operator): self
    {
        $this->operator = $operator;
        return $this;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof CompoundItem) {
            throw new InvalidArgumentException();
        }

        if (!$operator = $expression->getOperator()) {
            return '';
        }
        $text = '';
        if ($operator instanceof NotOperatorInterface) {
            $expression->isNot() && $operator->not();
        } else {
            $text = $expression->isNot() ? 'NOT ' : '';
        }
        if ($operator instanceof ExpressionOperator) {
            $expressionOperator = $operator->getExpression();
            if (is_callable($expressionOperator)) {
                $connection = $expression->compound->getConnection();
                $container = new ClauseContainer($connection) ;
                call_user_func($expressionOperator, $container);
                $operator->setExpression($container);
            }
        }
        return $text .  $this->compiler->compile($operator);
    }

    /**
     * @return string
     */
    public function getCompoundString(): string
    {
        return $this->compoundString;
    }
}
