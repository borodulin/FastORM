<?php

declare(strict_types=1);

namespace FastOrm\ORM\Entity;

class Entity implements EntityInterface
{
    use EntityTrait;

    public function getPrimaryKey(): string
    {
        // TODO: Implement getPrimaryKey() method.
    }
}
