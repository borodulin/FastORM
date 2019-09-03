<?php

declare(strict_types=1);

namespace FastOrm\Command;

interface ParamsBinderAwareInterface
{
    public function setParamsBinder(ParamsBinderInterface $paramsBinder);
}
