<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\JoinClause;
use FastOrm\SQL\Clause\Select\JoinItem;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\InvalidSQLException;

class JoinClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @param ExpressionInterface $expression
     * @return string
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
            if (is_string($join)) {
                if (strpos($join, '(') === false) {
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
                $join = '(' . $this->compiler->compile($join) . ')';
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
