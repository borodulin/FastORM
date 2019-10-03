<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\ParamsAwareInterface;
use FastOrm\SQL\ParamsAwareTrait;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;

class LikeOperatorBuilder implements ExpressionInterface, CompilerAwareInterface, ParamsAwareInterface
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

    public function __toString(): string
    {
        $value = $this->likeOperator->getValue();
        if ($value instanceof ExpressionInterface) {
            $like = $this->compiler->compile($value);
        } else {
            $value = "%$value%";
            $like = ':' . $this->params->bindValue($value);
        }
        $operator = $this->getOperator();
        $column = $this->likeOperator->getColumn();
        return "$column $operator $like";
    }

    protected function getOperator()
    {
        return 'LIKE';
    }
}
