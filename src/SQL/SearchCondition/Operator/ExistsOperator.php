<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\QueryInterface;

class ExistsOperator implements OperatorInterface, ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }

    public function build(): string
    {
        $sql = $this->compiler->compile($this->query);
        return "EXISTS($sql)";
    }
}
