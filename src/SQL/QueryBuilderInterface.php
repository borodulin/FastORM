<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL;

use Borodulin\ORM\SQL\Clause\Delete\WhereClauseInterface;
use Borodulin\ORM\SQL\Clause\Insert\ColumnsClauseInterface;
use Borodulin\ORM\SQL\Clause\Select\SelectDistinctInterface;
use Borodulin\ORM\SQL\Clause\UpdateClauseInterface;

interface QueryBuilderInterface
{
    public function select($columns = []): SelectDistinctInterface;

    public function update($table): UpdateClauseInterface;

    public function insertInto($table): ColumnsClauseInterface;

    public function deleteFrom($table): WhereClauseInterface;
}
