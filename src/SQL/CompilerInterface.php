<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL;

use Borodulin\ORM\EventDispatcherAwareInterface;
use Psr\Log\LoggerAwareInterface;

interface CompilerInterface extends LoggerAwareInterface, EventDispatcherAwareInterface
{
    public function compile(ExpressionInterface $expression): string;

    public function getParams(): ParamsInterface;

    public function quoteColumnName(string $name): string;

    public function quoteTableName(string $name): string;
}
