<?php

declare(strict_types=1);

namespace FastOrm\SQL;

class Params implements ParamsInterface
{
    public const PARAM_PREFIX = 'p';

    private $params = [];
    private $counter = 0;

    private $paramsPattern = '/^[:@](.+)$/';

    public function __construct(iterable $params = [])
    {
        $this->bindAll($params);
    }

    public function bindAll(iterable $params): void
    {
        foreach ($params as $name => $value) {
            if (preg_match($this->paramsPattern, $name, $matches)) {
                $name = $matches[1];
            }
            $this->params[$name] = $value;
        }
    }

    public function bindValue($value): string
    {
        if (\is_string($value) && (preg_match($this->paramsPattern, $value, $matches))) {
            $paramName = $matches[1];
            if (!isset($this->params[$paramName])) {
                $this->bindOne($paramName, null);
            }
        } else {
            $paramName = self::PARAM_PREFIX.++$this->counter;
            $this->bindOne($paramName, $value);
        }

        return $paramName;
    }

    public function bindOne($name, $value): void
    {
        $this->params[$name] = $value;
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
        return isset($this->params[$offset]);
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
        return $this->params[$offset];
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
     * @since 5.0.0
     */
    public function offsetSet($offset, $value): void
    {
        $this->params[$offset] = $value;
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
     */
    public function offsetUnset($offset): void
    {
        unset($this->params[$offset]);
    }

    /**
     * Return the current element.
     *
     * @see https://php.net/manual/en/iterator.current.php
     *
     * @return mixed can return any type
     *
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->params);
    }

    /**
     * Move forward to next element.
     *
     * @see https://php.net/manual/en/iterator.next.php
     *
     * @return void any returned value is ignored
     *
     * @since 5.0.0
     */
    public function next(): void
    {
        next($this->params);
    }

    /**
     * Return the key of the current element.
     *
     * @see https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     *
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->params);
    }

    /**
     * Checks if current position is valid.
     *
     * @see https://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     *
     * @since 5.0.0
     */
    public function valid()
    {
        return null !== key($this->params);
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @see https://php.net/manual/en/iterator.rewind.php
     *
     * @return void any returned value is ignored
     *
     * @since 5.0.0
     */
    public function rewind(): void
    {
        reset($this->params);
    }

    /**
     * Count elements of an object.
     *
     * @see https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     *             </p>
     *             <p>
     *             The return value is cast to an integer.
     *
     * @since 5.1.0
     */
    public function count()
    {
        return \count($this->params);
    }
}
