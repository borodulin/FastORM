<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\EventDispatcherAwareInterface;
use Psr\Log\LoggerAwareInterface;

interface CompilerInterface extends LoggerAwareInterface, EventDispatcherAwareInterface
{
    public function compile(ExpressionInterface $expression): string;

    public function getContext(): ContextInterface;

    public function quoteColumnName(string $name): string;
    public function quoteTableName(string $name): string;
}
