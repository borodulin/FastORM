<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;


use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;

class LikeOperatorBuilder implements ExpressionBuilderInterface, CompilerAwareInterface, ParamsAwareInterface
{
    use CompilerAwareTrait, ParamsAwareTrait;

    /**
     * @var LikeOperator
     */
    private $likeOperator;

    public function __construct(LikeOperator $likeOperator)
    {
        $this->likeOperator = $likeOperator;
    }

    public function build(): string
    {
        $value = $this->likeOperator->getValue();
        if ($value instanceof ExpressionInterface) {
            $value = $this->compiler->compile($value);
        }
        $value = "%$value%";
        $paramName = $this->params->bindValue($value);
        $operator = $this->getOperator();
        $column = $this->likeOperator->getColumn();
        return "$column $operator :$paramName";
    }

    protected function getOperator()
    {
        return 'LIKE';
    }
}
