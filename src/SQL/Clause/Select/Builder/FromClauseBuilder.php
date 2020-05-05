<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select\Builder;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Select\AliasClause;
use Borodulin\ORM\SQL\Clause\Select\FromClause;
use Borodulin\ORM\SQL\Clause\SelectClauseInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class FromClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof FromClause) {
            throw new InvalidArgumentException();
        }

        $aliases = $expression->getFrom();
        if (0 === \count($aliases)) {
            return '';
        }

        $result = [];

        $counter = 0;

        /** @var AliasClause $alias */
        foreach ($aliases as $alias) {
            $from = $alias->getExpression();
            $aliasName = $alias->getAlias();
            if ($from instanceof SelectClauseInterface) {
                $sql = $this->compiler->compile($from);
                $aliasName = $aliasName ?? 's'.++$counter;
                $result[] = "($sql) ".$this->compiler->quoteTableName($aliasName);
            } elseif ($from instanceof ExpressionInterface) {
                $sql = $this->compiler->compile($from);
                $aliasName = $aliasName ? ' '.$this->compiler->quoteTableName($aliasName) : '';
                $result[] = "$sql".$aliasName;
            } elseif (\is_string($from)) {
                if (false === strpos($from, '(')) {
                    if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $from, $matches)) { // with alias
                        $from = $matches[1];
                        $aliasName = $matches[2];
                    }
                    $from = $this->compiler->quoteTableName($from);
                    $aliasName && $aliasName = $this->compiler->quoteTableName($aliasName);
                }
                $result[] = $aliasName ? "$from $aliasName" : $from;
            }
        }
        $from = 'FROM '.implode(', ', $result);

        return $from;
    }
}
