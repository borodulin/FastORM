<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\ClauseInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Expression\SearchExpression;
use InvalidArgumentException;

class ClauseBuilderFactory implements ClauseBuilderFactoryInterface
{
    private static $defaultClassMap = [
        SelectClause::class => SelectClauseClauseBuilder::class,
        FromClause::class => FromClauseClauseBuilder::class,
        JoinClause::class => JoinClauseClauseBuilder::class,
        SearchExpression::class => SearchExpressionClauseBuilder::class,
        GroupByClause::class => GroupByClauseClauseBuilder::class,
        UnionClause::class => UnionClauseClauseBuilder::class,
        OrderByClause::class => OrderByClauseClauseBuilder::class,
    ];
    /**
     * @var array
     */
    private $classMap;

    public function __construct(array $classMap = [])
    {
        $this->classMap = $classMap ? array_replace(static::$defaultClassMap, $classMap) : static::$defaultClassMap;
    }

    public function build(ClauseInterface $clause): ClauseBuilderInterface
    {
        $classBuilder = $this->classMap[get_class($clause)] ?? null;
        if ($classBuilder) {
            return new $classBuilder($clause);
        }
        throw new InvalidArgumentException();
    }
}
