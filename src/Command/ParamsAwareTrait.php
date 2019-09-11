<?php

declare(strict_types=1);

namespace FastOrm\Command;


trait ParamsAwareTrait
{
    /**
     * @var ParamsInterface
     */
    protected $params;

    public function setParams(ParamsInterface $paramsBinder)
    {
        $this->params = $paramsBinder;
    }
}
