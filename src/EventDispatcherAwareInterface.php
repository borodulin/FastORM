<?php

declare(strict_types=1);

namespace Borodulin\ORM;

use Psr\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherAwareInterface
{
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void;
}
