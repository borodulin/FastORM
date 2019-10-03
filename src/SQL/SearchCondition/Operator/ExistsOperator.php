<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;

class ExistsOperator implements OperatorInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var SelectInterface
     */
    private $query;

    public function __construct(SelectInterface $query)
    {
        $this->query = $query;
    }

    public function __toString()
    {
        $sql = $this->compiler->compile($this->query);
        return "EXISTS($sql)";
    }
}
