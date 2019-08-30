<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Driver\BindParamsInterface;

interface BuilderInterface
{
    public function getText(): string;
}
