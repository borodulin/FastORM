<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

/**
 * Class InOperator
 * @package FastOrm\SQL\Operator
 */
class InOperator implements OperatorInterface
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
}
