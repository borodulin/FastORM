<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ContextInterface;

class LikeOperator extends AbstractOperator
{
    private $column;
    private $value;

    public function __construct($column, $value, ContextInterface $context)
    {
        $this->column = $column;
        $this->value = $value;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }
}
