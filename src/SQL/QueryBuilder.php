<?php
/** @noinspection PhpMissingParentConstructorInspection */

declare(strict_types=1);

namespace FastOrm\SQL;

class QueryBuilder extends Query implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var Query
     */
    private $query;

    /**
     * QueryBuilder constructor.
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function build(): string
    {
        return implode(' ', array_filter([
            $this->compiler->compile($this->query->selectClause),
            $this->compiler->compile($this->query->fromClause),
            $this->compiler->compile($this->query->whereClause),
            $this->compiler->compile($this->query->groupByClause),
            $this->compiler->compile($this->query->havingClause),
            $this->compiler->compile($this->query->unionClause),
            $this->compiler->compile($this->query->orderByClause),
            $this->compiler->compile($this->query->limitClause),
        ]));
    }
}
