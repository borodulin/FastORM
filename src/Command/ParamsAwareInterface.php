<?php

declare(strict_types=1);

namespace FastOrm\Command;

interface ParamsAwareInterface
{
    public function setParams(ParamsInterface $params);
}
