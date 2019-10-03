<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;

class FilterHashConditionOperator implements OperatorInterface, CompilerAwareInterface
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

    public function __toString(): string
    {
        $hash = array_filter($this->hash);
        return $this->compiler->compile(new HashConditionOperator($hash));
    }
}
