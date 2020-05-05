<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Params;
use Borodulin\ORM\Tests\TestCase;

class ParamsTest extends TestCase
{
    public function testCount(): void
    {
        $params = new Params(['p1' => 1]);
        $this->assertCount(1, $params);
        $params['p2'] = '2';
        $this->assertCount(2, $params);
    }

    public function testIterate(): void
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        $params2 = new Params();
        foreach ($params as $name => $value) {
            $params2[$name] = $value;
        }
        $this->assertEquals($params, $params2);
    }

    public function testClone(): void
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        $params2 = clone $params;
        $this->assertEquals($params, $params2);
    }

    public function testAssign(): void
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        $params2 = new Params($params);
        $this->assertEquals($params, $params2);
    }

    public function testUnset(): void
    {
        $params = new Params(['p1' => 1, 'p2' => 2]);
        unset($params['p1']);
        $this->assertCount(1, $params);
    }

    public function testGet(): void
    {
        $params = new Params(['p1' => 11, 'p2' => 2]);
        $this->assertTrue(isset($params['p1']));
        $this->assertEquals(11, $params['p1']);
    }
}
