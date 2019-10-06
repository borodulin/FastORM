<?php

declare(strict_types=1);

namespace FastOrm\ORM;

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
        $this->selectQuery = new SelectQuery($connection);
        $this->selectQuery->from($tableName);
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
        return $this->findByPk((string)$offset)
            ->getSelectQuery()->fetch()->exists();
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
        return $this->findByPk((string)$offset)
            ->getSelectQuery()->fetch()->one();
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
        if (is_array($primaryKey)) {
            $pk = explode(',', $pk);
            $hash = array_combine($primaryKey, (array)$pk);
        } else {
            $hash = [$primaryKey => $pk];
        }
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
        return $this->selectQuery;
    }

    protected function getSelectQuery(): SelectClauseInterface
    {
        return $this->selectQuery;
    }
}
