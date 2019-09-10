<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;


use PDO;
use PDOStatement;

class Cursor implements CursorInterface
{

    /**
     * @var PDOStatement
     */
    private $statement;

    private $row;
    private $key = 0;

    private $fetchStyle = PDO::FETCH_ASSOC;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
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
        $this->row = $this->statement->fetch(
            $this->fetchStyle,
            PDO::FETCH_ORI_ABS,
            $this->key
        );
        if (false === $this->row) {
            return null;
        }
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
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->key = 0;
    }
}
