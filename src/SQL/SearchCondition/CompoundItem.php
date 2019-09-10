<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

class CompoundItem
{
    /**
     * @var SearchCondition
     */
    private $searchCondition;
    /**
     * @var string
     */
    private $compound;

    public function __construct(SearchCondition $searchCondition, string $compound)
    {
        $this->searchCondition = $searchCondition;
        $this->compound = $compound;
    }

    /**
     * @return SearchCondition
     */
    public function getCondition(): SearchCondition
    {
        return $this->searchCondition;
    }

    /**
     * @return string
     */
    public function getCompound(): string
    {
        return $this->compound;
    }
}
