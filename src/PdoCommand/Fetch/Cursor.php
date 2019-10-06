<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

use FastOrm\NotSupportedException;
use PDO;
use PDOStatement;

class Cursor implements CursorInterface
{
    private $row;
    private $key = 0;

    private $limit;
    private $rowHandler;

    /**
     * @var PDOStatement
     */
    private $statement;
    /**
     * @var int
     */
    private $fetchStyle;

    public function __construct(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC)
    {
        $this->statement = $statement;
        $this->fetchStyle = $fetchStyle;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->row;
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->key++;
        if ($this->limit && ($this->key() > $this->limit)) {
            $this->closeCursor();
            $this->setRow(false);
            return;
        }
        $this->setRow($this->statement->fetch($this->fetchStyle));
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->row !== false;
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @throws NotSupportedException
     * @since 5.0.0
     */
    public function rewind()
    {
        if ($this->key === 0) {
            $this->key = 1;
            $this->setRow($this->statement->fetch($this->fetchStyle));
        } else {
            throw new NotSupportedException('Cursor cannot rewind.');
        }
    }

    protected function setRow($row): void
    {
        if (($row !== false) && is_callable($this->rowHandler)) {
            $this->row = call_user_func($this->rowHandler, $row);
        } else {
            $this->row = $row;
        }
    }

    protected function closeCursor(): void
    {
        $this->statement->closeCursor();
        $this->row = false;
    }

    /**
     * @param int $limit
     * @return BatchCursorInterface
     */
    public function setLimit(int $limit): CursorInterface
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param callable $rowHandler
     * @return $this
     */
    public function setRowHandler(callable $rowHandler): CursorInterface
    {
        $this->rowHandler = $rowHandler;
        return $this;
    }
}
