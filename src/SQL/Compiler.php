<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\ParamsBinderAwareInterface;
use FastOrm\Command\ParamsBinderInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Builder\FromClauseBuilder;
use FastOrm\SQL\Clause\Builder\GroupByClauseBuilder;
use FastOrm\SQL\Clause\Builder\HavingClauseBuilder;
use FastOrm\SQL\Clause\Builder\JoinClauseBuilder;
use FastOrm\SQL\Clause\Builder\LimitClauseBuilder;
use FastOrm\SQL\Clause\Builder\OrderByClauseBuilder;
use FastOrm\SQL\Clause\Builder\SelectClauseBuilder;
use FastOrm\SQL\Clause\Builder\UnionClauseBuilder;
use FastOrm\SQL\Clause\Builder\WhereClauseBuilder;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\HavingClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\LimitClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\WhereClause;
use FastOrm\SQL\SearchCondition\Builder\CompoundBuilder;
use FastOrm\SQL\SearchCondition\Builder\SearchConditionBuilder;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\SearchCondition;

class Compiler implements CompilerInterface
{
    private static $defaultClassMap = [
        SelectClause::class => SelectClauseBuilder::class,
        FromClause::class => FromClauseBuilder::class,
        WhereClause::class => WhereClauseBuilder::class,
        JoinClause::class => JoinClauseBuilder::class,
        GroupByClause::class => GroupByClauseBuilder::class,
        HavingClause::class => HavingClauseBuilder::class,
        UnionClause::class => UnionClauseBuilder::class,
        OrderByClause::class => OrderByClauseBuilder::class,
        LimitClause::class => LimitClauseBuilder::class,

        Compound::class => CompoundBuilder::class,
        SearchCondition::class => SearchConditionBuilder::class,

        Query::class => QueryBuilder::class,
    ];

    /**
     * @var array
     */
    private $classMap;
    /**
     * @var ParamsBinderInterface
     */
    private $bindParams;

    public function __construct(ParamsBinderInterface $bindParams, array $classMap = [])
    {
        $this->classMap = $classMap ? array_replace(static::$defaultClassMap, $classMap) : static::$defaultClassMap;
        $this->bindParams = $bindParams;
    }

    public function compile(ExpressionInterface $expression): string
    {
        $classBuilder = $this->classMap[get_class($expression)] ?? null;
        if ($classBuilder) {
            $instance = new $classBuilder($expression);
            if (!$instance instanceof ExpressionBuilderInterface) {
                throw new InvalidArgumentException();
            }
        } elseif ($expression instanceof ExpressionBuilderInterface) {
            $instance = $expression;
        } else {
            throw new InvalidArgumentException();
        }
        if ($instance instanceof ParamsBinderAwareInterface) {
            $instance->setParamsBinder($this->bindParams);
        }
        if ($instance instanceof CompilerAwareInterface) {
            $instance->setCompiler($this);
        }
        return $instance->build();
    }

    public function quoteColumnName(string $name): string
    {
        return $name;
    }

    public function quoteTableName(string $name): string
    {
        return $name;
    }
}
