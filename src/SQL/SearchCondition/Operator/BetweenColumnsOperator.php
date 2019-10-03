<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ParamsAwareInterface;
use FastOrm\SQL\ParamsAwareTrait;

class BetweenColumnsOperator implements
    NotOperatorInterface,
    ParamsAwareInterface,
    CompilerAwareInterface
{
    use ParamsAwareTrait, CompilerAwareTrait;

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

    public function setNot(bool $value): void
    {
        $this->not = $value;
    }

    public function __toString(): string
    {
        $paramName = $this->params->bindValue($this->value);
        $intervalStartColumn = $this->compiler->quoteColumnName($this->intervalStartColumn);
        $intervalEndColumn = $this->compiler->quoteColumnName($this->intervalEndColumn);
        return ":$paramName BETWEEN $intervalStartColumn AND $intervalEndColumn";
    }
}
