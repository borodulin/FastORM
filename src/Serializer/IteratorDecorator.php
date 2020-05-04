<?php

declare(strict_types=1);

namespace AppBundle\Serializer;

class IteratorDecorator implements \Iterator
{
    /**
     * @var object
     */
    private $object;
    /**
     * @var \ReflectionClass
     */
    private $reflection;
    /**
     * @var array
     */
    private $readableProps;

    public function __construct(object $object)
    {
        $this->object = $object;
        $this->reflection = new \ReflectionClass($object);
        foreach ($this->reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $methodName) {
            if ('get' === substr($methodName, 0, 3)) {
                $this->readableProps[strtolower(substr($methodName, 3))] = $methodName;
            }
            if ('is' === substr($methodName, 0, 2)) {
                $this->readableProps[strtolower(substr($methodName, 2))] = $methodName;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->object->{current($this->readableProps)};
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        next($this->readableProps);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->readableProps);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return null !== $this->key();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        reset($this->readableProps);
    }
}
