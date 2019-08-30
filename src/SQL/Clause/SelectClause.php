<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

class SelectClause extends AbstractClause
{
    /**
     * @var bool
     */
    private $distinct = false;
    private $columns = [];
    /**
     * @var string
     */
    private $option;

    public function addColumns($columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return bool
     */
    public function isDistinct(): bool
    {
        return $this->distinct;
    }

    /**
     * @param bool $distinct
     */
    public function setDistinct(bool $distinct): void
    {
        $this->distinct = $distinct;
    }

    /**
     * @return string
     */
    public function getOption(): ?string
    {
        return $this->option;
    }

    /**
     * @param string $option
     */
    public function setOption(string $option): void
    {
        $this->option = $option;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}
