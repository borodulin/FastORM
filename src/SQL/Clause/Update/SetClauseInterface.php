<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

interface SetClauseInterface
{
    public function set(array $set): WhereClauseInterface;
}
