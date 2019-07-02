<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

class Operator
{
    /**
     * @var OperatorInterface
     */
    private $operator;
    /**
     * @var bool|null
     */
    private $not;

    public function __construct(OperatorInterface $operator, ?bool $not)
    {
        $this->operator = $operator;
        $this->not = $not;
    }
}
