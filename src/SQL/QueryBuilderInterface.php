<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\SQL\Clause\Delete\WhereClauseInterface;
use FastOrm\SQL\Clause\Insert\ColumnsClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\Update\SetClauseInterface;

interface QueryBuilderInterface
{
    public function select(): SelectClauseInterface;

    public function update($table): SetClauseInterface;

    public function insertInto($table): ColumnsClauseInterface;

    public function deleteFrom($table): WhereClauseInterface;
}
