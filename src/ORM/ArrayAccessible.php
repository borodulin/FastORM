<?php

declare(strict_types=1);

namespace Borodulin\ORM\ORM;

use ArrayAccess;
use Borodulin\ORM\NotSupportedException;
use Borodulin\ORM\SQL\Clause\SelectClauseInterface;

class ArrayAccessible implements ArrayAccess
{
    /**
     * @var string
     */
    private $entityClass;
    /**
     * @var SelectClauseInterface
     */
    private $selectClause;

    public function __construct(string $entityClass, SelectClauseInterface $selectClause)
    {
        $this->entityClass = $entityClass;
        $this->selectClause = $selectClause;
    }

    /**
     * Whether a offset exists.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     *
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        $hash = PkHelper::getAsHash($this->entityClass, $offset);
        $cursor = $this->selectClause->where()
            ->hashCondition($hash)->fetch()->cursor()->setLimit(1);
        $cursor->rewind();

        return null !== $cursor->current();
    }

    /**
     * Offset to retrieve.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed can return all value types
     *
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        $hash = PkHelper::getAsHash($this->entityClass, $offset);
        $cursor = $this->selectClause->where()
            ->hashCondition($hash)->fetch()->cursor()->setLimit(1);
        $cursor->rewind();

        return $cursor->current();
    }

    /**
     * Offset to set.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @throws NotSupportedException
     *
     * @since 5.0.0
     */
    public function offsetSet($offset, $value): void
    {
        throw new NotSupportedException();
    }

    /**
     * Offset to unset.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @since 5.0.0
     *
     * @throws NotSupportedException
     */
    public function offsetUnset($offset): void
    {
        throw new NotSupportedException();
    }
}
