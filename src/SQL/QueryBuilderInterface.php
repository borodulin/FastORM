<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\SQL\Clause\DeleteClauseInterface;
use FastOrm\SQL\Clause\InsertClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\UpdateClauseInterface;

interface QueryBuilderInterface
{
    public function select(): SelectClauseInterface;

    public function update(): UpdateClauseInterface;

    public function insert(): InsertClauseInterface;

    public function delete(): DeleteClauseInterface;
}
