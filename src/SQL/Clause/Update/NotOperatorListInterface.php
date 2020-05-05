<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Update;

interface NotOperatorListInterface extends OperatorListInterface
{
    public function not(): OperatorListInterface;
}
