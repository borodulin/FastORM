<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BuilderInterface;

/**
 * Class InOperator
 * @package FastOrm\SQL\Operator
 */
class InOperator implements OperatorInterface, BuilderInterface
{
    private $column;
    private $values;

    /**
     * InOperator constructor.
     * @param $column
     * @param $values
     */
    public function __construct($column, $values)
    {
        $this->column = $column;
        $this->values = $values;
    }

    public function getText(): string
    {
        return "$this->column in :values";
    }
}
