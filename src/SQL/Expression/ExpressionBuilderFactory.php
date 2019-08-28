<?php


namespace FastOrm\SQL\Expression;


class ExpressionBuilderFactory implements ExpressionBuilderFactoryInterface
{

    public function build(SearchExpressionInterface $expression): ExpressionBuilderInterface
    {
        return new SearchExpressionBuilder();
    }
}
