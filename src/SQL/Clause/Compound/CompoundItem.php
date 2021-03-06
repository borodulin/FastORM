<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Compound;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Operator\ExpressionOperator;
use Borodulin\ORM\SQL\Clause\Operator\NotOperatorInterface;
use Borodulin\ORM\SQL\Clause\Operator\OperatorInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

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
     * @return CompoundItem
     */
    public function setOperator(OperatorInterface $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
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
            if (\is_callable($expressionOperator)) {
                $connection = $expression->compound->getConnection();
                $container = new ClauseContainer($connection);
                \call_user_func($expressionOperator, $container);
                $operator->setExpression($container);
            }
        }

        return $text.$this->compiler->compile($operator);
    }

    public function getCompoundString(): string
    {
        return $this->compoundString;
    }
}
