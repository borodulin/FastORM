<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\HasContextInterface;

class AbstractOperator implements HasContextInterface, OperatorInterface
{
    /**
     * @var ContextInterface
     */
    protected $context;

    public function __construct(ContextInterface $context)
    {
        $this->context = $context;
    }

    public function __toString()
    {
        return (string)$this->context;
    }

    public function getContext(): ContextInterface
    {
        return $this->context;
    }
}
