<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Params;
use FastOrm\Tests\TestCase;

class ParamsTest extends TestCase
{
    public function testCount()
    {
        $params = new Params(['p1' => 1]);
        $this->assertCount(1, $params);
        $params['p2'] = '2';
        $this->assertCount(2, $params);
    }

    public function testIterate()
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        $params2 = new Params();
        foreach ($params as $name => $value) {
            $params2[$name] = $value;
        }
        $this->assertEquals($params, $params2);
    }

    public function testClone()
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        $params2 = clone $params;
        $this->assertEquals($params, $params2);
    }

    public function testAssign()
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        $params2 = new Params($params);
        $this->assertEquals($params, $params2);
    }

    public function testUnset()
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        unset($params['p1']);
        $this->assertCount(1, $params);
    }

    public function testGet()
    {
        $params = new Params(['p1' => 11, 'p2' => 2]);
        $this->assertTrue(isset($params['p1']));
        $this->assertEquals(11, $params['p1']);
    }
}
