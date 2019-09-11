<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\ConditionInterface;

/**
 * Class AbstractSearchConditionClause
 * @package FastOrm\SQL\Clause
 */
class AbstractSearchConditionClause extends AbstractClause
{
    private $compound;

    public function __construct(Query $query)
    {
        parent::__construct($query);
        $this->compound = new Compound($query);
    }

    public function getCondition(): ConditionInterface
    {
        return $this->compound->getCondition();
    }

    /**
     * @return Compound
     */
    public function getCompound(): Compound
    {
        return $this->compound;
    }
}
