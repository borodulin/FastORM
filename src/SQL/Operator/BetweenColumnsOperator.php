<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

class BetweenColumnsOperator implements OperatorInterface
{
    private $value;
    private $intervalStartColumn;
    private $intervalEndColumn;

    public function __construct($value, $intervalStartColumn, $intervalEndColumn)
    {
        $this->value = $value;
        $this->intervalStartColumn = $intervalStartColumn;
        $this->intervalEndColumn = $intervalEndColumn;
    }
}
