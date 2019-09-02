<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface ExpressionBuilderInterface
{
    public function build(ExpressionInterface $expression): string;
}
