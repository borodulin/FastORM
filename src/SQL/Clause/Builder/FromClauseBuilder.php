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
            $aliasName = $alias->getAlias() ?? 's' . ++$counter;
            $aliasName = $this->compiler->quoteTableName($aliasName);
            if ($from instanceof ExpressionInterface) {
                $sql = $this->compiler->compile($from);
                $result[] = "($sql) " . $aliasName;
            } elseif (is_string($from)) {
                $from = $this->compiler->quoteTableName($from);
                $result[] = "$from " . $aliasName;
            } elseif (strpos($alias, '(') === false) {
                if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $from, $matches)) { // with alias
                    $result[] = $this->compiler->quoteTableName($matches[1])
                        . ' ' . $this->compiler->quoteTableName($matches[2]);
                } else {
                    $result[] = $this->compiler->quoteTableName($from);
                }
            }
        }
        return 'FROM ' . implode(', ', $result);
    }
}
