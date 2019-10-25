<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\SQL\Clause\Delete\WhereClauseInterface;
use FastOrm\SQL\Clause\Insert\ColumnsClauseInterface;
use FastOrm\SQL\Clause\Select\SelectDistinctInterface;
use FastOrm\SQL\Clause\UpdateClauseInterface;

interface QueryBuilderInterface
{
    public function select($columns = []): SelectDistinctInterface;

    public function update($table): UpdateClauseInterface;

    public function insertInto($table): ColumnsClauseInterface;

    public function deleteFrom($table): WhereClauseInterface;
}
