<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class QueryBuilderTest
 * @package FastOrm\Tests\SQL
 * @covers \FastOrm\Connection
 * @covers \FastOrm\SQL\Query
 * @covers \FastOrm\Command\Params
 * @covers \FastOrm\Command\Command
 * @covers \FastOrm\Command\Fetch\Fetch
 * @covers \FastOrm\Command\PdoValue
 * @covers \FastOrm\Command\StatementFactory
 * @covers \FastOrm\Driver\AbstractDriver
 * @covers \FastOrm\SQL\Clause\FromClause
 * @covers \FastOrm\SQL\Clause\Builder\FromClauseBuilder
 * @covers \FastOrm\Command\ParamsAwareTrait::setParams
 * @covers \FastOrm\Driver\DriverFactory
 * @covers \FastOrm\SQL\Clause\AbstractSearchConditionClause
 */
class QueryBuilderTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @covers \FastOrm\SQL\SearchCondition\Operator\BetweenOperator
     * @covers \FastOrm\SQL\Clause\WhereClause
     * @covers \FastOrm\SQL\SearchCondition\Compound
     * @throws NotSupportedException
     */
    public function testParamBinding()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()
            ->expression('1=:p1', [':p1' => 1])
            ->and()->between('AlbumId', ':p1', ':p2')
            ->prepare($connection);
        $fetch = $command->fetch();
        $this->assertCount(0, $fetch->all());
        $fetch = $command->fetch(['p2' => 10]);
        $this->assertCount(10, $fetch->all());
        $fetch = $command->fetch(['p1' => 2]);
        $this->assertCount(0, $fetch->all());
    }

    /**
     * @covers \FastOrm\SQL\SearchCondition\SearchCondition
     * @covers \FastOrm\SQL\SearchCondition\Builder\SearchConditionBuilder
     * @covers \FastOrm\SQL\SearchCondition\Operator\ExpressionOperator
     * @covers \FastOrm\SQL\SearchCondition\Compound
     * @covers \FastOrm\SQL\SearchCondition\Builder\CompoundBuilder
     * @throws NotSupportedException
     */
    public function testOr()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()->equal('AlbumId', 1)
            ->or()->in('AlbumId', [2,3])
            ->and()->expression(function (ConditionInterface $condition) {
                return $condition->in('AlbumId', [1,2])->or()->equal('AlbumId', 3);
            })
            ->prepare($connection);
        $fetch = $command->fetch();
        $all = $fetch->all();
        $this->assertCount(3, $all);
    }

    /**
     * @covers \FastOrm\SQL\SearchCondition\Operator\HashConditionOperator
     * @throws NotSupportedException
     */
    public function testHashCondition()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()->hashCondition(['AlbumId' => [1,':tt']])
            ->prepare($connection);
        $fetch = $command->fetch();
        $this->assertCount(1, $fetch->all());
        $fetch = $command->fetch(['tt' => 2]);
        $this->assertCount(2, $fetch->all());
    }

    /**
     * @covers \FastOrm\SQL\Clause\JoinClause
     * @covers \FastOrm\SQL\Clause\Builder\JoinClauseBuilder
     * @covers \FastOrm\SQL\Clause\AliasClause
     * @covers \FastOrm\SQL\Clause\LimitClause
     * @covers \FastOrm\SQL\Clause\Builder\LimitClauseBuilder
     * @throws NotSupportedException
     */
    public function testJoin()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->innerJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->innerJoin('media_types')->alias('mt')->on('mt.MediaTypeId=t.MediaTypeId')
            ->limit(10)
            ->prepare($connection);
        $all = $command->fetch()->all();
        $this->assertCount(10, $all);
    }

    /**
     * @covers \FastOrm\SQL\Clause\SelectClause
     * @covers \FastOrm\SQL\Clause\Builder\SelectClauseBuilder
     * @throws NotSupportedException
     */
    public function testSelect()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select(['TrackId', 'Name'])->select('*')
            ->from('tracks')->alias('t')
            ->limit(10)
            ->prepare($connection);
        $all = $command->fetch()->all();
        $this->assertCount(10, $all);
    }

    /**
     * @covers \FastOrm\SQL\SearchCondition\Operator\LikeOperator
     * @covers \FastOrm\Driver\Postgres\LikeOperatorBuilder
     * @covers \FastOrm\SQL\Clause\Builder\LimitClauseBuilder
     * @covers \FastOrm\SQL\Clause\AliasClause
     * @throws NotSupportedException
     */
    public function testLike()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->where()->like('Name', 'rock')
            ->limit(5)
            ->prepare($connection);
        $all = $command->fetch()->all();
        foreach ($all as $row) {
            $this->assertStringContainsStringIgnoringCase('rock', $row['Name']);
        }
    }
}
