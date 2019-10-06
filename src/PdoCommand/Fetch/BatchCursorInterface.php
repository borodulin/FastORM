<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

interface BatchCursorInterface extends CursorInterface
{
    public function setBatchSize(int $batchSize): self;

    public function setBatchHandler(callable $batchHandler): self;
}
