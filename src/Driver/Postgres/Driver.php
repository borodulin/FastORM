<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver\Postgres;

use Borodulin\ORM\Driver\AbstractDriver;
use Borodulin\ORM\Driver\SavepointInterface;
use Borodulin\ORM\Driver\SavepointTrait;
use Borodulin\ORM\SQL\Clause\Operator\LikeOperator;
use Borodulin\ORM\SQL\CompilerInterface;

class Driver extends AbstractDriver implements SavepointInterface
{
    use SavepointTrait;

    public function createCompiler(): CompilerInterface
    {
        return new Compiler([
            LikeOperator::class => LikeOperatorBuilder::class,
        ]);
    }
}
