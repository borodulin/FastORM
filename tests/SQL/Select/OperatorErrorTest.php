<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\Driver\Postgres\LikeOperatorBuilder;
use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Operator\BetweenColumnsOperator;
use Borodulin\ORM\SQL\Clause\Operator\BetweenOperator;
use Borodulin\ORM\SQL\Clause\Operator\CompareColumnsOperator;
use Borodulin\ORM\SQL\Clause\Operator\CompareOperator;
use Borodulin\ORM\SQL\Clause\Operator\EqualOperator;
use Borodulin\ORM\SQL\Clause\Operator\ExistsOperator;
use Borodulin\ORM\SQL\Clause\Operator\ExpressionOperator;
use Borodulin\ORM\SQL\Clause\Operator\FilterHashConditionOperator;
use Borodulin\ORM\SQL\Clause\Operator\HashConditionOperator;
use Borodulin\ORM\SQL\Clause\Operator\InOperator;
use Borodulin\ORM\SQL\Clause\Select\AliasClause;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

class OperatorErrorTest extends TestCase
{
    public function testBetweenColumnsOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new BetweenColumnsOperator('', '', ''))->build(new AliasClause());
    }

    public function testBetweenOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new BetweenOperator('', '', ''))->build(new AliasClause());
    }

    public function testCompareOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new CompareOperator('', '', ''))->build(new AliasClause());
    }

    public function testEqualOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new EqualOperator('', ''))->build(new AliasClause());
    }

    public function testExistsOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ExistsOperator(new SelectQuery($this->db)))->build(new AliasClause());
    }

    public function testExpressionOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ExpressionOperator(''))->build(new AliasClause());
    }

    public function testFilterHashConditionOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new FilterHashConditionOperator([]))->build(new AliasClause());
    }

    public function testHashConditionOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new HashConditionOperator([]))->build(new AliasClause());
    }

    public function testInOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new InOperator('', ''))->build(new AliasClause());
    }

    public function testLikeOperatorBuilder(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new LikeOperatorBuilder())->build(new AliasClause());
    }

    public function testCompareColumnsOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new CompareColumnsOperator('', '', ''))->build(new AliasClause());
    }
}
