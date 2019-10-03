<?php

declare(strict_types=1);

namespace FastOrm\Driver\Postgres;

use FastOrm\Driver\AbstractDriver;
use FastOrm\Driver\SavepointInterface;
use FastOrm\Driver\SavepointTrait;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\CompilerInterface;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;

class Driver extends AbstractDriver implements SavepointInterface
{
    use SavepointTrait;

    public function createCompiler(ContextInterface $context): CompilerInterface
    {
        return new Compiler($context, [
            LikeOperator::class => LikeOperatorBuilder::class,
        ]);
    }
}
