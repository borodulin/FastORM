<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL;

interface CompilerAwareInterface
{
    public function setCompiler(CompilerInterface $compiler);
}
