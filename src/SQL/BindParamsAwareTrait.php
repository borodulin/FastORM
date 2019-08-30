<?php

declare(strict_types=1);

namespace FastOrm\SQL;


trait BindParamsAwareTrait
{
    /**
     * @var BindParamsInterface
     */
    protected $bindParams;

    public function setBindParams(BindParamsInterface $bindParams)
    {
        $this->bindParams = $bindParams;
    }
}
