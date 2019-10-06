<?php

declare(strict_types=1);

namespace FastOrm\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use TestConnectionTrait;
}
