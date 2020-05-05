<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Operator\LikeOperator;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class LikeOperatorBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    protected function getOperator()
    {
        return 'LIKE';
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof LikeOperator) {
            throw new InvalidArgumentException();
        }

        $value = $expression->getValue();
        if ($value instanceof ExpressionInterface) {
            $like = $this->compiler->compile($value);
        } else {
            $value = "%$value%";
            $like = ':'.$this->compiler->getParams()->bindValue($value);
        }
        $operator = $this->getOperator();
        $column = $expression->getColumn();
        $column = $this->compiler->quoteColumnName($column);

        return "$column $operator $like";
    }
}
