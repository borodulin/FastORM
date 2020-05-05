<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Delete;

interface NotOperatorListInterface extends OperatorListInterface
{
    public function not(): OperatorListInterface;
}
