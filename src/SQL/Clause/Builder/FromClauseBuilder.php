<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\Driver\BindParamsInterface;
use FastOrm\SQL\Clause\AliasClause;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\ExpressionInterface;

class FromClauseBuilder extends AbstractClauseBuilder
{
    /**
     * @var FromClause
     */
    protected $clause;

    public function __construct(FromClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $aliases = $this->clause->getFrom();
        if ($aliases->count() === 0) {
            return '';
        }

        $from = [];

        /** @var AliasClause $alias */
        foreach ($aliases as $alias) {
            $expression = $alias->getExpression();
            if ($expression instanceof ExpressionInterface) {
                $sql = $this->buildExpression($expression);
                $from[] = "($sql) " . $alias->getAlias();
            } elseif (is_string($expression)) {
                $from[] = "$expression " . $alias->getAlias();
            } elseif (strpos($alias, '(') === false) {
                if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $expression, $matches)) { // with alias
                    $from[] = $matches[1] . ' ' . $matches[2];
                } else {
                    $from[] = $expression;
                }
            }
        }

        return 'FROM ' . implode(', ', $from);
    }
}
