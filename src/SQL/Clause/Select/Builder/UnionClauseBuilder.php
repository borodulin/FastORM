<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Select\UnionClause;
use Borodulin\ORM\SQL\Clause\Select\UnionItem;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

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
