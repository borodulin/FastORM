<?php

declare(strict_types=1);

namespace FastOrm\SQL;

trait ExpressionBuilderAwareTrait
{
    /**
     * @var ExpressionBuilderInterface
     */
    protected $expressionBuilder;

    public function setExpressionBuilder(ExpressionBuilderInterface $expressionBuilder)
    {
        $this->expressionBuilder = $expressionBuilder;
    }
}
