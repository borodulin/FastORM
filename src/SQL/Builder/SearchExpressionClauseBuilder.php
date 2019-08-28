<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Expression\SearchExpression;

class SearchExpressionClauseBuilder implements ClauseBuilderInterface
{

    /**
     * @var SearchExpression
     */
    private $expression;

    public function __construct(SearchExpression $expression)
    {
        $this->expression = $expression;
    }

    public function getSql(): string
    {
        return 'WHERE';
    }
}
