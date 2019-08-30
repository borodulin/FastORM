<?php

namespace FastOrm\SQL;

interface BuilderFactoryInterface
{
    public function build(ExpressionInterface $expression): BuilderInterface;
}
