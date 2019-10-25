<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class SelectQueryTest extends TestCase
{
    public function testSelect()
    {
        $query = new SelectQuery($this->db);
        $query->select(new Expression('1'));
        $this->assertEquals('SELECT 1', (string)$query);
    }

    public function testFrom()
    {
        $query = new SelectQuery($this->db);
        $query->from(new Expression('Artist'));
        $this->assertEquals('SELECT * FROM Artist', (string)$query);
    }

    public function testGroupBy()
    {
        $query = new SelectQuery($this->db);
        $query->groupBy(new Expression('ArtistId'));
        $this->assertEquals('SELECT * GROUP BY ArtistId', (string)$query);
    }

    public function testHaving()
    {
        $query = new SelectQuery($this->db);
        $query->having()->expression('count(*)>10');
        $this->assertEquals('SELECT * HAVING (count(*)>10)', (string)$query);
    }

    public function testOrderBy()
    {
        $query = new SelectQuery($this->db);
        $query->orderBy(new Expression('ArtistId'));
        $this->assertEquals('SELECT * ORDER BY ArtistId', (string)$query);
    }

    public function testLimit()
    {
        $query = new SelectQuery($this->db);
        $query->limit(10);
        $this->assertEquals('SELECT * LIMIT 10', (string)$query);
    }

    public function testOffset()
    {
        $query = new SelectQuery($this->db);
        $query->offset(10);
        $this->assertEquals('SELECT * OFFSET 10', (string)$query);
    }

    public function testUnion()
    {
        $query = new SelectQuery($this->db);
        $query->union(new SelectQuery($this->db));
        $this->assertEquals('SELECT * UNION SELECT *', (string)$query);
    }

    public function testUnionAll()
    {
        $query = new SelectQuery($this->db);
        $query->unionAll(new SelectQuery($this->db));
        $this->assertEquals('SELECT * UNION ALL SELECT *', (string)$query);
    }

    public function testWhere()
    {
        $query = new SelectQuery($this->db);
        $query->where()->expression('1=1');
        $this->assertEquals('SELECT * WHERE (1=1)', (string)$query);
    }

    /**
     * @throws DbException
     */
    public function testFetch()
    {
        $query = new SelectQuery($this->db);
        $query->from('Album');
        $exists = $query->fetch()->exists();
        $this->assertTrue($exists);
    }

    /**
     * @throws DbException
     */
    public function testStatement()
    {
        $query = new SelectQuery($this->db);
        $query->from('Album');
        $count = $query->statement()->execute()->columnCount();
        $this->assertEquals(3, $count);
    }

    public function testCount()
    {
        $query = new SelectQuery($this->db);
        $query->from('Album');
        $count = $query->count();
        $this->assertGreaterThan(100, $count);
    }

    public function testBuild()
    {
        $query = new SelectQuery($this->db);
        $compiler = $this->db->getDriver()->createCompiler();
        $sql = $compiler->compile($query);
        $this->assertEquals('SELECT *', $sql);
    }
}
