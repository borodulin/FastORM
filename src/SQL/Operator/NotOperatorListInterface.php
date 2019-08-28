<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

interface NotOperatorListInterface extends OperatorListInterface
{
    public function not(): OperatorListInterface;
}
