<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface QueryBuilderInterface
{
    public function getSQL(): string;
}
