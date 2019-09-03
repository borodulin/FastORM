<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface CompilerAwareInterface
{
    public function setCompiler(CompilerInterface $compiler);
}
