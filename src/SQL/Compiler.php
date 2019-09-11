<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
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
use FastOrm\SQL\Clause\ClauseInterface;
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
use FastOrm\SQL\SearchCondition\Builder\LikeOperatorBuilder;
use FastOrm\SQL\SearchCondition\Builder\SearchConditionBuilder;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;
use FastOrm\SQL\SearchCondition\SearchCondition;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use SplObjectStorage;

class Compiler implements CompilerInterface
{
    use LoggerAwareTrait, EventDispatcherAwareTrait;

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
        LikeOperator::class => LikeOperatorBuilder::class,
    ];

    /**
     * @var array
     */
    private $classMap;
    /**
     * @var ParamsInterface
     */
    private $bindParams;

    private $queries;

    public function __construct(ParamsInterface $bindParams, array $classMap = [])
    {
        $this->classMap = $classMap ? array_replace(static::$defaultClassMap, $classMap) : static::$defaultClassMap;
        $this->bindParams = $bindParams;
        $this->queries = new SplObjectStorage();
    }

    /**
     * @param ExpressionInterface $expression
     * @return string
     * @throws InvalidSQLException
     */
    public function compile(ExpressionInterface $expression): string
    {
        if ($expression instanceof ClauseInterface) {
            $query = $expression->getQuery();
            if (!$this->queries->contains($query)) {
                $this->queries->attach($expression);
                return $this->compile($query);
            }
        } elseif ($expression instanceof QueryInterface) {
            if (!$this->queries->contains($expression)) {
                $this->queries->attach($expression);
            } else {
                throw new InvalidSQLException();
            }
        }

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
        if ($instance instanceof ParamsAwareInterface) {
            $instance->setParams($this->bindParams);
        }
        if ($instance instanceof CompilerAwareInterface) {
            $instance->setCompiler($this);
        }
        if ($this->logger && $instance instanceof LoggerAwareInterface) {
            $instance->setLogger($this->logger);
        }
        if ($this->eventDispatcher && $instance instanceof EventDispatcherAwareInterface) {
            $instance->setEventDispatcher($this->eventDispatcher);
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
