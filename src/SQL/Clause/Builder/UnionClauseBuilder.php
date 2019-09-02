<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\UnionItem;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class UnionClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof UnionClause) {
            throw new InvalidArgumentException();
        }
        $unions = $expression->getUnions();
        if (empty($unions)) {
            return '';
        }

        $result = '';

        /** @var UnionItem $union */
        foreach ($unions as $union) {
            $query = $this->expressionBuilder->build($union->getQuery());
            $result .= 'UNION ' . ($union->isAll() ? 'ALL ' : '') . '( ' . $query . ' ) ';
        }

        return trim($result);
    }
}
