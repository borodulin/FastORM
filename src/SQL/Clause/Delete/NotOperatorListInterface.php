<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Delete;

interface NotOperatorListInterface extends OperatorListInterface
{
    public function not(): OperatorListInterface;
}
