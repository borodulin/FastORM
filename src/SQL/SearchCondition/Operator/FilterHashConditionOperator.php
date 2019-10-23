<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class FilterHashConditionOperator implements
    OperatorInterface,
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
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof FilterHashConditionOperator) {
            throw new InvalidArgumentException();
        }
        $hash = array_filter($expression->hash);
        return $this->compiler->compile(new HashConditionOperator($hash));
    }
}
