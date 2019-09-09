<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryDecoratorTrait;
use FastOrm\SQL\QueryInterface;

abstract class AbstractClause implements ClauseInterface, QueryInterface
{
    use QueryDecoratorTrait;
}
