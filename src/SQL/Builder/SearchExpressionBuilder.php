<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Expression\SearchExpression;

class SearchExpressionBuilder implements BuilderInterface
{

    /**
     * @var SearchExpression
     */
    private $expression;

    public function __construct(SearchExpression $expression)
    {
        $this->expression = $expression;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
