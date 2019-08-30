<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

interface NotOperatorInterface extends OperatorInterface
{
    public function setNot(bool $value): void;
}
