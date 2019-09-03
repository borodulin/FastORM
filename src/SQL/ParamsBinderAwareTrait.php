<?php

declare(strict_types=1);

namespace FastOrm\SQL;


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
