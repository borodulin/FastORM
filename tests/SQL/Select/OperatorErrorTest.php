<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\Driver\Postgres\LikeOperatorBuilder;
use FastOrm\InvalidArgumentException;
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
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class OperatorErrorTest extends TestCase
{
    /**
     */
    public function testBetweenColumnsOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new BetweenColumnsOperator('', '', ''))->build(new AliasClause());
    }

    public function testBetweenOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new BetweenOperator('', '', ''))->build(new AliasClause());
    }

    public function testCompareOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new CompareOperator('', '', ''))->build(new AliasClause());
    }

    public function testEqualOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new EqualOperator('', ''))->build(new AliasClause());
    }

    public function testExistsOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new ExistsOperator(new SelectQuery($this->db)))->build(new AliasClause());
    }

    public function testExpressionOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new ExpressionOperator(''))->build(new AliasClause());
    }

    public function testFilterHashConditionOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new FilterHashConditionOperator([]))->build(new AliasClause());
    }

    public function testHashConditionOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new HashConditionOperator([]))->build(new AliasClause());
    }

    public function testInOperator()
    {
        $this->expectException(InvalidArgumentException::class);
        (new InOperator('', ''))->build(new AliasClause());
    }

    public function testLikeOperatorBuilder()
    {
        $this->expectException(InvalidArgumentException::class);
        (new LikeOperatorBuilder())->build(new AliasClause());
    }
}
