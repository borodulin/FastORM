<?php

declare(strict_types=1);

namespace FastOrm\ORM;

interface EntityInterface
{
    public static function getPrimaryKey(): array;
}
