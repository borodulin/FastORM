<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface ParamsBinderAwareInterface
{
    public function setParamsBinder(ParamsBinderInterface $paramsBinder);
}
