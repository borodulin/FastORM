<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Select\LimitClause;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class LimitClauseBuilder implements ExpressionBuilderInterface
{
    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof LimitClause) {
            throw new InvalidArgumentException();
        }

        $sql = [];
        if ($limit = $expression->getLimit()) {
            $sql[] = 'LIMIT '.$limit;
        }
        if ($offset = $expression->getOffset()) {
            $sql[] = 'OFFSET '.$offset;
        }

        return implode(' ', $sql);
    }
}
