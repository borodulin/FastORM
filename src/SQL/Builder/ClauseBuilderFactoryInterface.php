<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\ClauseInterface;

interface ClauseBuilderFactoryInterface
{
    public function build(ClauseInterface $clause): ClauseBuilderInterface;
}
