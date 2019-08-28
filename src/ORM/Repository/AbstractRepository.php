<?php

declare(strict_types=1);

namespace FastOrm\ORM\Repository;

use FastOrm\ORM\Entity\EntityCollectionInterface;
use FastOrm\ORM\Entity\EntityInterface;

class AbstractRepository implements RepositoryInterface
{

    public function findAll(): EntityCollectionInterface
    {
        // TODO: Implement findAll() method.
    }

    public function findOne(): EntityInterface
    {
        // TODO: Implement findOne() method.
    }
}
