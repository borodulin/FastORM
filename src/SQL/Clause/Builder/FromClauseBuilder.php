<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\AliasClause;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class FromClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var FromClause
     */
    private $clause;

    public function __construct(FromClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        $aliases = $this->clause->getFrom();
        if ($aliases->count() === 0) {
            return '';
        }

        $result = [];

        $counter = 0;

        /** @var AliasClause $alias */
        foreach ($aliases as $alias) {
            $from = $alias->getExpression();
            $aliasName = $alias->getAlias();
            if ($from instanceof ExpressionInterface) {
                $sql = $this->compiler->compile($from);
                $aliasName = $aliasName ?? 's' . ++$counter;
                $result[] = "($sql) " . $this->compiler->quoteTableName($aliasName);
            } elseif (is_string($from)) {
                if (strpos($from, '(') === false) {
                    if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $from, $matches)) { // with alias
                        $from = $this->compiler->quoteTableName($matches[1]);
                        $aliasName = $this->compiler->quoteTableName($matches[2]);
                    }
                }
                $aliasName = $aliasName ?? $this->compiler->quoteTableName('s' . ++$counter);
                $result[] = "$from " . $aliasName;
            }
        }
        $from = 'FROM ' . implode(', ', $result);
        if ($join = $this->compiler->compile($this->clause->getJoinClause())) {
            $from .= ' ' . $join;
        }
        return $from;
    }
}
