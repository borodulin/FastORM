<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

interface FetchAllInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function all(iterable $params = []): array;
}
