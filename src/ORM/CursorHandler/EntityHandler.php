<?php

declare(strict_types=1);

namespace FastOrm\ORM\CursorHandler;

use FastOrm\InvalidArgumentException;
use FastOrm\ORM\EntityInterface;
use ReflectionClass;
use ReflectionException;

class EntityHandler
{
    /**
     * @var string
     */
    private $classname;
    /**
     * @var ReflectionClass
     */
    private $reflection;
    /**
     * @var array
     */
    private $lowerNames;
    /**
     * @var array
     */
    private $lowerKey;

    /**
     * ClassRowHandler constructor.
     *
     * @throws ReflectionException
     */
    public function __construct(string $classname)
    {
        $this->reflection = new ReflectionClass($classname);
        if (!$this->reflection->implementsInterface(EntityInterface::class)) {
            throw new InvalidArgumentException();
        }
        /* @var EntityInterface $classname */
        $this->classname = $classname;
        foreach ($this->reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $this->lowerNames[strtolower($property->name)] = $property;
        }
        $pk = $yourArray = array_map('strtolower', $classname::getPrimaryKey());
        $this->lowerKey = array_combine($pk, $pk);
    }

    public function __invoke(array $row)
    {
        $instance = $this->reflection->newInstance();
        $row = array_change_key_case($row);
        foreach ($this->lowerNames as $lowerName => $property) {
            if (\array_key_exists($lowerName, $row)) {
                $property->setValue($instance, $row[$lowerName]);
            }
        }
        $key = implode(',', array_intersect_key($row, $this->lowerKey));

        return [$instance, $key];
    }
}
