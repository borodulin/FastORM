<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\ConditionInterface;

/**
 * Class AbstractSearchConditionClause
 * @package FastOrm\SQL\Clause
 */
abstract class AbstractSearchConditionClause extends AbstractClause
{
    private $compound;

    public function __construct(SelectQuery $query)
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
