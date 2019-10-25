<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Insert;

interface ColumnsClauseInterface
{
    public function columns(array $columns): ValuesClauseInterface;
}
