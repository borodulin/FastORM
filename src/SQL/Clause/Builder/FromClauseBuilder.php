<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\AliasClause;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class FromClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof FromClause) {
            throw new InvalidArgumentException();
        }
        $aliases = $expression->getFrom();
        if ($aliases->count() === 0) {
            return '';
        }

        $result = [];

        $counter = 0;

        /** @var AliasClause $alias */
        foreach ($aliases as $alias) {
            $from = $alias->getExpression();
            $aliasName = $alias->getAlias() ?? 's' . ++$counter;
            if ($from instanceof ExpressionInterface) {
                $sql = $this->expressionBuilder->build($from);
                $result[] = "($sql) " . $aliasName;
            } elseif (is_string($from)) {
                $result[] = "$from " . $aliasName;
            } elseif (strpos($alias, '(') === false) {
                if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $from, $matches)) { // with alias
                    $result[] = $matches[1] . ' ' . $matches[2];
                } else {
                    $result[] = $from;
                }
            }
        }
        return 'FROM ' . implode(', ', $result);
    }
}
