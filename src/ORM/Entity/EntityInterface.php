<?php

declare(strict_types=1);

namespace FastOrm\ORM\Entity;

use Ds\Hashable;

interface EntityInterface extends Hashable
{
    public function getPrimaryKey(): string;
}
