<?php

declare(strict_types=1);

namespace FastOrm\ORM\Fetch;


interface FetchRelationInterface
{
    public function with(): FetchRelationInterface;
}
