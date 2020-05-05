<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Select\GroupByClause;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class GroupByClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof GroupByClause) {
            throw new InvalidArgumentException();
        }
        $columns = $expression->getColumns();
        if (empty($columns)) {
            return '';
        }
        foreach ($columns as $i => $column) {
            if ($column instanceof ExpressionInterface) {
                $column = $this->compiler->compile($column);
            } else {
                $column = $this->compiler->quoteColumnName($column);
            }
            $columns[$i] = $column;
        }

        return 'GROUP BY '.implode(', ', $columns);
    }
}
