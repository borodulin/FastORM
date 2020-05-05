<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver\Postgres;

use Borodulin\ORM\SQL\Clause\Operator\Builder\LikeOperatorBuilder as BaseLikeOperatorBuilder;

class LikeOperatorBuilder extends BaseLikeOperatorBuilder
{
    protected function getOperator()
    {
        return 'ILIKE';
    }
}
