<?php

declare(strict_types=true);

namespace FastOrm\ORM;

use FastOrm\SQL\QueryInterface;

interface EntityQueryInterface extends QueryInterface
{
    public function with($name): self;
}
