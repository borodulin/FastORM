<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\SelectClauseInterface;
use ReflectionClass;
use ReflectionException;

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
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

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
        $this->queryBuilder = new QueryBuilder($this->connection, $entityClass, $tableName);
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
        $hash = $this->getPkAsHash($offset);
        return $this->queryBuilder->select()->where()
            ->hashCondition($hash)->fetch()->exists();
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
        $hash = $this->getPkAsHash($offset);
        $cursor = $this->queryBuilder->select()->where()
            ->hashCondition($hash)->fetch()->cursor()->setLimit(1);
        $cursor->rewind();
        return $cursor->current();
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
        $hash = $this->getPkAsHash($offset);
        if ($this->offsetExists($offset)) {
            $this->queryBuilder->update()
                ->set($value)->where()->hashCondition($hash)
                ->execute();
        } else {
            $this->queryBuilder->insert()
                ->columns($value)
                ->execute();
        }
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
        $hash = $this->getPkAsHash($offset);
        $this->queryBuilder->delete()->where()
            ->hashCondition($hash)->execute();
    }

    public function getPkAsHash($pk): array
    {
        $primaryKey = $this->entityClass::getPrimaryKey();
        $pk = explode(',', (string)$pk);
        return $hash = array_combine($primaryKey, (array)$pk);
    }

    public function __clone()
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }
}
