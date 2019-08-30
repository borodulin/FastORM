<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BuilderInterface;

class BetweenColumnsOperator implements NotOperatorInterface, BuilderInterface
{
    private $value;
    private $intervalStartColumn;
    private $intervalEndColumn;
    /**
     * @var bool
     */
    private $not;

    public function __construct($value, $intervalStartColumn, $intervalEndColumn)
    {
        $this->value = $value;
        $this->intervalStartColumn = $intervalStartColumn;
        $this->intervalEndColumn = $intervalEndColumn;
    }

    public function getText(): string
    {
        // TODO: Implement getText() method.
    }

    public function setNot(bool $value): void
    {
        $this->not = $value;
    }
}
