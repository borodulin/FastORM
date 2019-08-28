<?php

declare(strict_types=1);

namespace FastOrm\ORM\Repository;

use FastOrm\ORM\Entity\EntityInterface;
use FastOrm\ORM\Entity\EntityCollectionInterface;

interface RepositoryInterface
{
    public function findAll(string $classname = null): EntityCollectionInterface;

    public function findOne(string $classname = null): ?EntityInterface;
}
