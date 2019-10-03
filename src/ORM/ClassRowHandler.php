<?php

declare(strict_types=1);

namespace FastOrm\ORM;

class ClassRowHandler
{
    /**
     * @var string
     */
    private $classname;

    public function __construct(string $classname)
    {
        $this->classname = $classname;
    }

    public function __invoke($row)
    {
        // TODO: Implement __invoke() method.
    }
}
