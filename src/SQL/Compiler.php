<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\Builder\FromClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\GroupByClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\HavingClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\JoinClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\LimitClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\OrderByClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\SelectClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\UnionClauseBuilder;
use FastOrm\SQL\Clause\Select\Builder\WhereClauseBuilder;
use FastOrm\SQL\Clause\Select\FromClause;
use FastOrm\SQL\Clause\Select\GroupByClause;
use FastOrm\SQL\Clause\Select\HavingClause;
use FastOrm\SQL\Clause\Select\JoinClause;
use FastOrm\SQL\Clause\Select\LimitClause;
use FastOrm\SQL\Clause\Select\OrderByClause;
use FastOrm\SQL\Clause\Select\SelectClause;
use FastOrm\SQL\Clause\Select\UnionClause;
use FastOrm\SQL\Clause\Select\WhereClause;
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
    private $params;

    private $queries;

    public function __construct(ParamsInterface $params, array $classMap = [])
    {
        $this->classMap = $classMap ? array_replace(static::$defaultClassMap, $classMap) : static::$defaultClassMap;
        $this->params = $params;
        $this->queries = new SplObjectStorage();
    }

    /**
     * @param ExpressionInterface $expression
     * @return string
     */
    public function compile(ExpressionInterface $expression): string
    {
        $classBuilder = $this->classMap[get_class($expression)] ?? null;
        if ($classBuilder) {
            $instance = new $classBuilder($expression);
            if (!$instance instanceof ExpressionInterface) {
                throw new InvalidArgumentException();
            }
        } else {
            $instance = $expression;
        }
        if ($instance instanceof ParamsAwareInterface) {
            $instance->setParams($this->params);
        }
        if ($instance instanceof CompilerAwareInterface) {
            $instance->setCompiler($this);
        }
        if ($this->logger && $instance instanceof LoggerAwareInterface) {
            $instance->setLogger($this->logger);
        }
        return $instance->__toString();
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
