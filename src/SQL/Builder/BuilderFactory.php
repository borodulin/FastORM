<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\ClauseInterface;

class BuilderFactory
{
    private static $classMap = [

    ];

    public function __invoke(ClauseInterface $clause, array $classMap = [])
    {
        $className = get_class($clause);
        $classBuilder = static::$classMap[$className] ?? $classMap[$className] ?? null;
        if ($classBuilder) {
            return new $classBuilder($clause);
        }
        throw new \InvalidArgumentException();
    }
}
