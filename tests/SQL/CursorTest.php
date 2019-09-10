<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\Tests\TestConnectionTrait;
//use PHPUnit\Framework\TestCase;

class CursorTest // extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testCursor()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->prepare($connection);
        $cursor = $command->cursor();
        echo count($cursor);
    }
}
