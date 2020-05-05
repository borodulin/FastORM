<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL;

trait CompilerAwareTrait
{
    /**
     * @var CompilerInterface
     */
    protected $compiler;

    public function setCompiler(CompilerInterface $compiler): void
    {
        $this->compiler = $compiler;
    }
}
