<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

class BatchCursor extends Cursor implements BatchCursorInterface
{
    private $batchSize;
    private $batchHandler;

    private $batchRows = [];

    protected function setRow($row): void
    {
        if ($row === false) {
            $this->handleBatch();
            parent::setRow($row);
            return;
        }
        if (is_callable($this->batchHandler)) {
            $this->batchRows[] = $row;
        }
        if ($this->batchSize && ($this->key() % $this->batchSize === 0)) {
            $this->handleBatch();
        }
        parent::setRow($row);
    }

    private function handleBatch()
    {
        if (is_callable($this->batchHandler)) {
            call_user_func($this->batchHandler, $this->batchRows);
            $this->batchRows = [];
        }
    }


    /**
     * @param int $batchSize
     * @return BatchCursorInterface
     */
    public function setBatchSize(int $batchSize): BatchCursorInterface
    {
        $this->batchSize = $batchSize;
        return $this;
    }

    /**
     * @param callable $batchHandler
     * @return BatchCursorInterface
     */
    public function setBatchHandler(callable $batchHandler): BatchCursorInterface
    {
        $this->batchHandler = $batchHandler;
        return $this;
    }
}
