<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

interface NotOperatorInterface extends OperatorInterface
{
    public function not(): void;
}
