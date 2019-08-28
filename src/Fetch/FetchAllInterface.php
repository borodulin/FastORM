<?php

declare(strict_types=1);

namespace FastOrm\Fetch;

interface FetchAllInterface
{
    public function all(): array;

    public function batch(int $batchSize = 100): BatchInterface;
}
