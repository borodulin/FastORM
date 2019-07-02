<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

interface NotOperatorListInterface extends OperatorListInterface
{
    public function not(): OperatorListInterface;
}
