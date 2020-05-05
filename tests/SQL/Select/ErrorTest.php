<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Compound\Compound;
use Borodulin\ORM\SQL\Clause\Operator\HashConditionOperator;
use Borodulin\ORM\SQL\Clause\Select\AliasClause;
use Borodulin\ORM\SQL\Clause\Select\ClauseContainer;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Compiler;
use Borodulin\ORM\SQL\ExpressionBuilder;
use Borodulin\ORM\Tests\TestCase;

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
