<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface BindParamsInterface
{
    public function bindParams(array $params): CommandInterface;
    public function bindParam($name, $value, int $dataType = null): CommandInterface;
    public function bindValue($value): CommandInterface;
}
