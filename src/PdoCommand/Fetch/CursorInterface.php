<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

use Iterator;

interface CursorInterface extends Iterator
{
    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit): self;

    /**
     * @param callable $rowHandler
     * @return $this
     */
    public function setRowHandler(callable $rowHandler): self;
}
