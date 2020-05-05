<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Select\OrderByClause;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class OrderByClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof OrderByClause) {
            throw new InvalidArgumentException();
        }
        $columns = $expression->getColumns();
        if (empty($columns)) {
            return '';
        }
        $orders = [];
        foreach ($columns as $name => $direction) {
            if ($direction instanceof ExpressionInterface) {
                $orders[] = $this->compiler->compile($direction);
            } else {
                $name = $this->compiler->quoteColumnName($name);
                $orders[] = $name.(SORT_DESC === $direction ? ' DESC' : '');
            }
        }

        return 'ORDER BY '.implode(', ', $orders);
    }
}
