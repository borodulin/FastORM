<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator;

interface NotOperatorInterface extends OperatorInterface
{
    public function not(): void;
}
