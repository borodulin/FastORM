<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\Driver\Postgres\LikeOperatorBuilder;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Compound\Compound;
use FastOrm\SQL\Clause\Operator\BetweenColumnsOperator;
use FastOrm\SQL\Clause\Operator\BetweenOperator;
use FastOrm\SQL\Clause\Operator\CompareOperator;
use FastOrm\SQL\Clause\Operator\EqualOperator;
use FastOrm\SQL\Clause\Operator\ExistsOperator;
use FastOrm\SQL\Clause\Operator\ExpressionOperator;
use FastOrm\SQL\Clause\Operator\FilterHashConditionOperator;
use FastOrm\SQL\Clause\Operator\HashConditionOperator;
use FastOrm\SQL\Clause\Operator\InOperator;
use FastOrm\SQL\Clause\Select\AliasClause;
use FastOrm\SQL\Clause\Select\ClauseContainer;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\ExpressionBuilder;
use FastOrm\Tests\TestCase;

class ErrorTest extends TestCase
{
    /**
     */
    public function testContainer()
    {
        $this->expectException(InvalidArgumentException::class);
        (new ClauseContainer($this->db))->build(new SelectQuery($this->db));
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
        (new Compound($this->db))
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
        (new ExistsOperator(new SelectQuery($this->db)))->build(new AliasClause());

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
    }
}
