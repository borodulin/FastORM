<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Compound\Compound;
use FastOrm\SQL\Clause\Operator\HashConditionOperator;
use FastOrm\SQL\Clause\Select\AliasClause;
use FastOrm\SQL\Clause\Select\ClauseContainer;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\ExpressionBuilder;
use FastOrm\Tests\TestCase;

class ErrorTest extends TestCase
{
    public function testContainer(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ClauseContainer($this->db))->build(new SelectQuery($this->db));
    }

    public function testExpressionBuilder(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ExpressionBuilder())->build(new HashConditionOperator([]));
    }

    public function testCompiler(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Compiler())->compile(new AliasClause());
    }

    public function testCompound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Compound($this->db))
            ->build(new AliasClause());
    }
}
