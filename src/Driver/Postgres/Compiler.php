<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver\Postgres;

use Borodulin\ORM\SQL\Compiler as BaseCompiler;

class Compiler extends BaseCompiler
{
    protected $quoteColumnChar = '"';
    protected $quoteTableChar = '"';
}
