<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Select\JoinClause;
use Borodulin\ORM\SQL\Clause\Select\JoinItem;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
use Borodulin\ORM\SQL\InvalidSQLException;

class JoinClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @throws InvalidSQLException
     */
    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof JoinClause) {
            throw new InvalidArgumentException();
        }

        $joins = $expression->getJoins();
        if (empty($joins)) {
            return '';
        }

        $result = [];
        /** @var JoinItem $joinItem */
        foreach ($joins as $joinItem) {
            $joinType = $joinItem->getJoinType();
            $join = $joinItem->getJoin();
            $alias = $joinItem->getAlias();
            if (\is_string($join)) {
                if (false === strpos($join, '(')) {
                    if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $join, $matches)) {
                        $join = $this->compiler->quoteTableName($matches[1]);
                        $alias = $matches[2];
                    }
                    $join = $this->compiler->quoteTableName($join);
                }
            } elseif ($join instanceof ExpressionInterface) {
                if (!$alias) {
                    throw new InvalidSQLException('The Alias for JOIN SQL expression is required.');
                }
                $join = '('.$this->compiler->compile($join).')';
            } else {
                throw new InvalidSQLException('Join SQL clause is invalid.');
            }
            $on = $joinItem->getOn();
            if ($on instanceof ExpressionInterface) {
                $on = $this->compiler->compile($on);
            }
            $alias && $alias = $this->compiler->quoteTableName($alias);
            $result[] = "$joinType $join $alias ON $on";
        }

        return implode(' ', $result);
    }
}
