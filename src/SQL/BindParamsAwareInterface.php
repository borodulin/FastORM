<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface BindParamsAwareInterface
{
    public function setBindParams(BindParamsInterface $bindParams);
}
