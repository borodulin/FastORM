<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundInterface;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;

/**
 * Class AbstractSearchConditionClause
 * @package FastOrm\SQL\Clause
 * @property CompoundInterface $query
 */
class AbstractSearchConditionClause extends AbstractClause
{
    private $compound;

    public function __construct(CompoundInterface $query)
    {
        parent::__construct($query);
        $this->compound = new Compound($query);
    }


    public function and(): SearchConditionInterface
    {
        return $this->compound->and();
    }

    public function or(): SearchConditionInterface
    {
        return $this->compound->or();
    }

    public function getSearchCondition(): SearchConditionInterface
    {
        return $this->compound->getSearchCondition();
    }

    /**
     * @return Compound
     */
    public function getCompound(): Compound
    {
        return $this->compound;
    }
}
