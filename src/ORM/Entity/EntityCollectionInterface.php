<?php

declare(strict_types=1);

namespace FastOrm\ORM\Entity;

use ArrayAccess;
use Ds\Collection;
use IteratorAggregate;

interface EntityCollectionInterface extends IteratorAggregate, ArrayAccess, Collection
{
}
