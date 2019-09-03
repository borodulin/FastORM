<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;

interface FetchIndexedInterface extends FetchAllInterface
{
    public function indexBy($column): FetchAllInterface;
}
