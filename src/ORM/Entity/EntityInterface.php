<?php

declare(strict_types=true);

namespace FastOrm\ORM\Entity;

use Ds\Hashable;

interface EntityInterface extends Hashable
{
    public function getPrimaryKey(): string;
}
