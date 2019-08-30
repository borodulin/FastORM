<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

interface NotOperatorListInterface extends OperatorListInterface
{
    public function not(): OperatorListInterface;
}
