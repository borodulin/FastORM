<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundInterface;
use FastOrm\SQL\SearchCondition\ConditionInterface;

/**
 * Class AbstractSearchConditionClause
 * @package FastOrm\SQL\Clause
 */
class AbstractSearchConditionClause extends AbstractClause implements CompoundInterface
{
    private $compound;

    public function __construct(QueryInterface $query)
    {
        parent::__construct($query);
        $this->compound = new Compound($query);
    }


    public function and(): ConditionInterface
    {
        return $this->compound->and();
    }

    public function or(): ConditionInterface
    {
        return $this->compound->or();
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
