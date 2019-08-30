<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

class FilterHashConditionOperator implements OperatorInterface
{
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
}
