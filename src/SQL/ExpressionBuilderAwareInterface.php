<?php

declare(strict_types=1);

namespace FastOrm\SQL;


interface ExpressionBuilderAwareInterface
{
    public function setExpressionBuilder(ExpressionBuilderInterface $expressionBuilder);
}
