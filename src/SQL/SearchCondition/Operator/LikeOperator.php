<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

class LikeOperator implements OperatorInterface
{
    private $column;
    private $value;

    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
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

    public function __toString()
    {
        //TODO
        return '';
    }
}
