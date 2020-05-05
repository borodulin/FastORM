<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\SQL\Clause\Operator\HashConditionOperator;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TestCase;

class SelectQueryTest extends TestCase
{
    public function testSelect(): void
    {
        $query = new SelectQuery($this->db);
        $query->select(new Expression('1'));
        $this->assertEquals('SELECT 1', (string) $query);
    }

    public function testFrom(): void
    {
        $query = new SelectQuery($this->db);
        $query->from(new Expression('Artist'));
        $this->assertEquals('SELECT * FROM Artist', (string) $query);
    }

    public function testGroupBy(): void
    {
        $query = new SelectQuery($this->db);
        $query->groupBy(new Expression('ArtistId'));
        $this->assertEquals('SELECT * GROUP BY ArtistId', (string) $query);
    }

    public function testHaving(): void
    {
        $query = new SelectQuery($this->db);
        $query->having()->expression('count(*)>10');
        $this->assertEquals('SELECT * HAVING (count(*)>10)', (string) $query);
    }

    public function testOrderBy(): void
    {
        $query = new SelectQuery($this->db);
        $query->orderBy(new Expression('ArtistId'));
        $this->assertEquals('SELECT * ORDER BY ArtistId', (string) $query);
    }

    public function testLimit(): void
    {
        $query = new SelectQuery($this->db);
        $query->limit(10);
        $this->assertEquals('SELECT * LIMIT 10', (string) $query);
    }

    public function testOffset(): void
    {
        $query = new SelectQuery($this->db);
        $query->offset(10);
        $this->assertEquals('SELECT * OFFSET 10', (string) $query);
    }

    public function testUnion(): void
    {
        $query = new SelectQuery($this->db);
        $query->union(new SelectQuery($this->db));
        $this->assertEquals('SELECT * UNION SELECT *', (string) $query);
    }

    public function testUnionAll(): void
    {
        $query = new SelectQuery($this->db);
        $query->unionAll(new SelectQuery($this->db));
        $this->assertEquals('SELECT * UNION ALL SELECT *', (string) $query);
    }

    public function testWhere(): void
    {
        $query = new SelectQuery($this->db);
        $query->where()->expression('1=1');
        $this->assertEquals('SELECT * WHERE (1=1)', (string) $query);
    }

    /**
     * @throws DbException
     */
    public function testFetch(): void
    {
        $query = new SelectQuery($this->db);
        $query->from('Album');
        $exists = $query->fetch()->exists();
        $this->assertTrue($exists);
    }

    /**
     * @throws DbException
     */
    public function testStatement(): void
    {
        $query = new SelectQuery($this->db);
        $query->from('Album');
        $count = $query->statement()->execute()->columnCount();
        $this->assertEquals(3, $count);
    }

    public function testCount(): void
    {
        $query = new SelectQuery($this->db);
        $query->from('Album');
        $count = $query->count();
        $this->assertGreaterThan(100, $count);
    }

    public function testBuild(): void
    {
        $query = new SelectQuery($this->db);
        $compiler = $this->db->getDriver()->createCompiler();
        $sql = $compiler->compile($query);
        $this->assertEquals('SELECT *', $sql);
    }

    public function testBuildError(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new SelectQuery($this->db))->build(new HashConditionOperator([]));
    }
}
