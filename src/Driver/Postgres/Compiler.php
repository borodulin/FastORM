<?php

declare(strict_types=1);

namespace FastOrm\Driver\Postgres;

use FastOrm\SQL\Compiler as BaseCompiler;

class Compiler extends BaseCompiler
{
    protected $quoteColumnChar = '"';
    protected $quoteTableChar = '"';
}
