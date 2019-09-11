<?php

declare(strict_types=1);

namespace FastOrm\Driver\Postgres;

use FastOrm\Command\ParamsInterface;
use FastOrm\Driver\AbstractDriver;
use FastOrm\Driver\SavepointInterface;
use FastOrm\Driver\SavepointTrait;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\CompilerInterface;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;

class Driver extends AbstractDriver implements SavepointInterface
{
    use SavepointTrait;

    public function createCompiler(ParamsInterface $params): CompilerInterface
    {
        return new Compiler($params, [
            LikeOperator::class => LikeOperatorBuilder::class,
        ]);
    }
}
