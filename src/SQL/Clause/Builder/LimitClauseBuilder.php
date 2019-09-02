<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\LimitClause;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class LimitClauseBuilder implements ExpressionBuilderInterface
{

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof LimitClause) {
            throw new InvalidArgumentException();
        }
        $sql = '';
        if ($limit = $expression->getLimit()) {
            $sql = 'LIMIT ' . $limit;
        }
        if ($offset = $expression->getOffset()) {
            $sql .= ' OFFSET ' . $offset;
        }
        return $sql;
    }
}
