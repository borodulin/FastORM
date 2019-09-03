<?php

declare(strict_types=1);

namespace FastOrm\Command;


trait ParamsBinderAwareTrait
{
    /**
     * @var ParamsBinderInterface
     */
    protected $paramsBinder;

    public function setParamsBinder(ParamsBinderInterface $paramsBinder)
    {
        $this->paramsBinder = $paramsBinder;
    }
}
