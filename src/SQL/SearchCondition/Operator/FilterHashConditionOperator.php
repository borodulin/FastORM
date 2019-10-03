<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class FilterHashConditionOperator extends AbstractOperator implements
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;
    /**
     * @var array
     */
    private $hash;

    /**
     * FilterHashOperator constructor.
     * @param array $hash
     * @param ContextInterface $context
     */
    public function __construct(array $hash, ContextInterface $context)
    {
        $this->hash = $hash;
        parent::__construct($context);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof FilterHashConditionOperator) {
            throw new InvalidArgumentException();
        }
        $hash = array_filter($expression->hash);
        return $this->compiler->compile(new HashConditionOperator($hash, $expression->context));
    }
}
