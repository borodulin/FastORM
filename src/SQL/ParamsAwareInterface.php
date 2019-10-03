<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface ParamsAwareInterface
{
    public function setParams(ParamsInterface $params): void;
}
