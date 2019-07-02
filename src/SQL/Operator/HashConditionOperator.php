<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

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
