<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ExistsOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    /**
     * @var SelectClauseInterface
     */
    private $query;

    public function __construct(SelectClauseInterface $query)
    {
        $this->query = $query;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof ExistsOperator) {
            throw new InvalidArgumentException();
        }
        $sql = $this->compiler->compile($expression->query);
        return "EXISTS($sql)";
    }
}
