<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class FilterHashConditionOperator implements OperatorInterface, ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;
    /**
     * @var array
     */
    private $hash;

    /**
     * FilterHashOperator constructor.
     * @param $hash
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }

    public function build(): string
    {
        $hash = array_filter($this->hash);
        return $this->compiler->compile(new HashConditionOperator($hash));
    }
}
