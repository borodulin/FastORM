<?php

declare(strict_types=1);

namespace FastOrm\Command;

interface ParamsInterface
{
    public function bindAll(array $params): void;
    public function bindOne($name, $value, int $dataType = null): void;

    /**
     * Returns generated parameter name
     * @param $value
     * @return string
     */
    public function bindValue($value): string;
}
