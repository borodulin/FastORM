<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface HasContextInterface
{
    public function getContext(): ContextInterface;
}
