<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;

use FastOrm\Command\Command;
use FastOrm\Command\DbException;
use FastOrm\NotSupportedException;
use Iterator;
use PDO;
use PDOStatement;

class Cursor implements CursorInterface
{

    /**
     * @var Command
     */
    private $command;

    private $row;
    private $key = -1;

    private $fetchStyle = PDO::FETCH_ASSOC;
    /**
     * @var bool
     */
    private $scrollable = false;
    /**
     * @var PDOStatement
     */
    private $statement;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return PDOStatement
     * @throws DbException
     */
    private function getStatement()
    {
        if ($this->scrollable) {
            return $this->command->executeStatement([
                PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
            ]);
        } else {
            return $this->command->executeStatement();
        }
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
        $this->row = $this->statement->fetch($this->fetchStyle);
        $this->key++;
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
     * @throws DbException
     * @throws NotSupportedException
     * @since 5.0.0
     */
    public function rewind()
    {
        if ($this->key < 0) {
            $this->statement = $this->getStatement();
            $this->row = $this->statement->fetch();
            $this->key = 0;
        } else {
            throw new NotSupportedException('Cursor cannot rewind.');
        }
    }

    public function scrollable(): Iterator
    {
        $this->scrollable = true;
        return $this;
    }
}
