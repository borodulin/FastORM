<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

class BatchCursor extends Cursor implements BatchCursorInterface
{
    private $limit;
    private $batchSize;
    private $rowHandler;
    private $batchHandler;

    private $batchRows = [];
    private $batchResults = [];

    private function handleBatch()
    {
        if (is_callable($this->batchHandler)) {
            call_user_func($this->batchHandler, $this->batchRows, $this->batchResults);
            $this->batchRows = [];
            $this->batchResults = [];
        }
    }


    protected function setRow($row): void
    {
        if ($row === false) {
            $this->handleBatch();
            parent::setRow($row);
            return;
        }
        if ($this->limit && ($this->key() > $this->limit)) {
            $this->closeCursor();
            $this->handleBatch();
            return;
        }
        if (is_callable($this->rowHandler)) {
            $result = call_user_func($this->rowHandler, $row);
        } else {
            $result = $row;
        }
        if (is_callable($this->batchHandler)) {
            $this->batchRows[] = $row;
            if (is_callable($this->rowHandler)) {
                $this->batchResults[] = $result;
            }
        }
        if ($this->batchSize && ($this->key() % $this->batchSize === 0)) {
            $this->handleBatch();
        }
        parent::setRow($result);
    }

    /**
     * @param int $limit
     * @return BatchCursorInterface
     */
    public function setLimit(int $limit): BatchCursorInterface
    {
        $this->limit = $limit;
        return $this;
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
     * @param callable $rowHandler
     * @return BatchCursorInterface
     */
    public function setRowHandler(callable $rowHandler): BatchCursorInterface
    {
        $this->rowHandler = $rowHandler;
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
