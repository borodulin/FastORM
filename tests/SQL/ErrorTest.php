<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\AliasClause;
use FastOrm\SQL\Clause\Select\ClauseContainer;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\ExpressionBuilder;
use FastOrm\SQL\SearchCondition\Builder\LikeOperatorBuilder;
use FastOrm\SQL\SearchCondition\Builder\SearchConditionBuilder;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\Operator\BetweenColumnsOperator;
use FastOrm\SQL\SearchCondition\Operator\BetweenOperator;
use FastOrm\SQL\SearchCondition\Operator\CompareOperator;
use FastOrm\SQL\SearchCondition\Operator\EqualOperator;
use FastOrm\SQL\SearchCondition\Operator\ExistsOperator;
use FastOrm\SQL\SearchCondition\Operator\ExpressionOperator;
use FastOrm\SQL\SearchCondition\Operator\FilterHashConditionOperator;
use FastOrm\SQL\SearchCondition\Operator\HashConditionOperator;
use FastOrm\SQL\SearchCondition\Operator\InOperator;
use FastOrm\Tests\TestCase;

class ErrorTest extends TestCase
{
    /**
     */
    public function testContainer()
    {
        $this->expectException(InvalidArgumentException::class);
        (new ClauseContainer($this->connection))->build(new SelectQuery($this->connection));
    }

    public function testExpressionBuilder()
    {
        $this->expectException(InvalidArgumentException::class);
        (new ExpressionBuilder())->build(new HashConditionOperator([]));
    }

    public function testCompiler()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Compiler())->compile(new AliasClause());
    }

    /**
     */
    public function testCompound()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Compound((new ClauseContainer($this->connection))))
            ->build(new AliasClause());
    }

    /**
     */
    public function testOperators()
    {
        $this->expectException(InvalidArgumentException::class);
        (new BetweenColumnsOperator('', '', ''))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new BetweenOperator('', '', ''))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new CompareOperator('', '', ''))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new EqualOperator('', ''))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new ExistsOperator(new SelectQuery($this->connection)))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new ExpressionOperator(''))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new FilterHashConditionOperator([]))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new HashConditionOperator([]))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new InOperator('', ''))->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new LikeOperatorBuilder())->build(new AliasClause());

        $this->expectException(InvalidArgumentException::class);
        (new SearchConditionBuilder())->build(new AliasClause());
    }
}