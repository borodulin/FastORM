<?php

declare(strict_types=1);

namespace FastOrm\Driver\Postgres;

use FastOrm\SQL\Clause\Operator\Builder\LikeOperatorBuilder as BaseLikeOperatorBuilder;

class LikeOperatorBuilder extends BaseLikeOperatorBuilder
{
    protected function getOperator()
    {
        return 'ILIKE';
    }
}
