<?php

declare(strict_types=1);

namespace Borodulin\ORM\ORM;

interface EntityInterface
{
    public static function getPrimaryKey(): array;
}
