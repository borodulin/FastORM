<?php

declare(strict_types=1);

namespace FastOrm\SQL\Expression;

interface ExpressionBuilderFactoryInterface
{
    public function build(SearchExpressionInterface $expression): ExpressionBuilderInterface;
}
