<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\Schema\SchemaInterface;
use FastOrm\SQL\Clause\ClauseInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Expression\SearchExpression;
use InvalidArgumentException;

class BuilderFactory
{
    private static $defaultClassMap = [
        SelectClause::class => SelectClauseBuilder::class,
        FromClause::class => FromClauseBuilder::class,
        JoinClause::class => JoinClauseBuilder::class,
        SearchExpression::class => SearchExpressionBuilder::class,
        GroupByClause::class => GroupByClauseBuilder::class,
        UnionClause::class => UnionClauseBuilder::class,
        OrderByClause::class => OrderByClauseBuilder::class,
    ];
    /**
     * @var SchemaInterface
     */
    private $schema;
    /**
     * @var array
     */
    private $classMap;

    public function __construct(SchemaInterface $schema)
    {
        $this->schema = $schema;
        $this->classMap = array_replace(static::$defaultClassMap, $schema->getClauseBuilderClassMap());
    }

    public function __invoke(ClauseInterface $clause): BuilderInterface
    {
        $classBuilder = $this->classMap[get_class($clause)] ?? null;
        if ($classBuilder) {
            return new $classBuilder($clause);
        }
        throw new InvalidArgumentException();
    }
}
