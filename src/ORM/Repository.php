<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use ArrayIterator;
use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\SelectQuery;
use ReflectionClass;
use ReflectionException;
use Traversable;

class Repository implements RepositoryInterface
{
    /**
     * @var EntityInterface
     */
    private $entityClass;
    /**
     * @var string|SelectClauseInterface
     */
    private $tableName;
    /**
     * @var SelectClauseInterface
     */
    private $selectQuery;
    /**
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var array|SelectClauseInterface
     */
    private $rows;

    /**
     * Repository constructor.
     * @param string $entityClass
     * @param $tableName
     * @param ConnectionInterface $connection
     * @throws ReflectionException
     */
    public function __construct(string $entityClass, $tableName, ConnectionInterface $connection)
    {
        $class = new ReflectionClass($entityClass);
        if (!$class->implementsInterface(EntityInterface::class)) {
            throw new InvalidArgumentException();
        }
        $this->entityClass = $entityClass;
        $this->tableName = $tableName;
        $this->connection = $connection;
        $this->initSelectQuery();
    }

    protected function initSelectQuery()
    {
        $this->selectQuery = new SelectQuery($this->connection);
        $this->selectQuery->from($this->tableName);
        $this->selectQuery->setCursorFactory(new CursorFactory($this->entityClass));
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return bool true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->all()[$offset]);
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if (isset($this->all()[$offset])) {
            return $this->all()[$offset];
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function findByPk(string $pk): self
    {
        $primaryKey = $this->entityClass::getPrimaryKey();
        $pk = explode(',', $pk);
        $hash = array_combine($primaryKey, (array)$pk);
        $this->selectQuery->where()->hashCondition($hash);
        return clone $this;
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->all());
    }

    protected function getSelectQuery(): SelectClauseInterface
    {
        return $this->selectQuery;
    }

    protected function getCursorFactory()
    {
        return new CursorFactory($this->entityClass);
    }

    public function __clone()
    {
        $this->rows = null;
        $this->selectQuery = clone $this->selectQuery;
    }

    public function all()
    {
        if ($this->rows === null) {
            $this->rows = iterator_to_array($this->selectQuery);
        }
        return $this->rows;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->rows);
    }

    public function withOne(RepositoryInterface $repository, array $link)
    {
    }

    public function withMany(RepositoryInterface $repository, array $link)
    {
    }

    public function joinWithOne()
    {
    }
}
