<?php

declare(strict_types=1);

namespace FastOrm\SQL;

interface CompilerInterface
{
    public function compile(ExpressionInterface $expression): string;

    public function quoteColumnName(string $name): string;
    public function quoteTableName(string $name): string;
}
