<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use ArrayAccess;
use Countable;
use Iterator;

interface ParamsInterface extends ArrayAccess, Iterator, Countable
{
    public function bindAll(iterable $params): void;
    public function bindOne($name, $value): void;

    /**
     * Returns generated parameter name
     * @param $value
     * @return string
     */
    public function bindValue($value): string;
}
