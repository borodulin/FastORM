<?php

declare(strict_types=1);

namespace FastOrm\SQL\Expression;

interface ExpressionBuilderInterface
{
    public function getSql();
}
