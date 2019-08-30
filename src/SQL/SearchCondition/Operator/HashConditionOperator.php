<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

class HashConditionOperator implements OperatorInterface
{
    /**
     * @var array
     */
    private $hash;

    /**
     * HashConditionOperator constructor.
     * @param $hash
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }
}
