<?php

declare(strict_types=true);

namespace FastOrm\SQL;

interface QueryBuilderInterface
{
    public function getSQL(): string;
}
