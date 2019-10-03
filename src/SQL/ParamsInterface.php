<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface ParamsInterface
{
    public function bindAll(array $params): void;
    public function bindOne($name, $value): void;

    /**
     * Returns generated parameter name
     * @param $value
     * @return string
     */
    public function bindValue($value): string;
}
