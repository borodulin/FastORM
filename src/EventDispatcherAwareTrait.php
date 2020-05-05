<?php

declare(strict_types=1);

namespace Borodulin\ORM;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherAwareTrait
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
