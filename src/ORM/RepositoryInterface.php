<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use ArrayAccess;
use IteratorAggregate;

interface RepositoryInterface extends ArrayAccess, IteratorAggregate
{
}
