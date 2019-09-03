<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ExpressionBuilderInterface;

/**
 * Class InOperator
 * @package FastOrm\SQL\Operator
 */
class InOperator implements OperatorInterface, ExpressionBuilderInterface
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

    public function build(): string
    {
        $values = implode(',', $this->values);
        return "$this->column in ($values)";
    }
}
