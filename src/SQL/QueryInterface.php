<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\SQL\Clause\Delete\DeleteClauseInterface;
use FastOrm\SQL\Clause\Insert\InsertClauseInterface;
use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\Clause\Update\UpdateClauseInterface;

interface QueryInterface
{
    public function select(): SelectInterface;

    public function update(): UpdateClauseInterface;

    public function insert(): InsertClauseInterface;

    public function delete(): DeleteClauseInterface;
}
