<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\UnionClause;
use FastOrm\SQL\Clause\Select\UnionItem;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class UnionClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

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
            $query = $this->compiler->compile($union->getQuery());
            $result .= ' UNION '.($union->isAll() ? 'ALL ' : '').$query;
        }

        return trim($result);
    }
}
