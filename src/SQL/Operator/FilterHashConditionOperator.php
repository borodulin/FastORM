<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

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
