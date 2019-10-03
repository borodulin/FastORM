<?php

declare(strict_types=1);

namespace FastOrm\SQL;

trait ParamsAwareTrait
{
    /**
     * @var ParamsInterface
     */
    protected $params;

    public function setParams(ParamsInterface $params): void
    {
        $this->params = $params;
    }
}
