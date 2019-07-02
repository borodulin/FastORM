<?php

declare(strict_types=true);

namespace FastOrm\ORM\Entity;

class Entity implements EntityInterface
{
    use EntityTrait;

    public function getPrimaryKey(): string
    {
        // TODO: Implement getPrimaryKey() method.
    }
}
