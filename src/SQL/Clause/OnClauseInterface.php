<?php


namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface OnClauseInterface
{
    public function on($condition): QueryInterface;
}
