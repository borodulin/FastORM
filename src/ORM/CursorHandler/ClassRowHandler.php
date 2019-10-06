<?php

declare(strict_types=1);

namespace FastOrm\ORM\CursorHandler;

use ReflectionClass;
use ReflectionException;

class ClassRowHandler
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
     * ClassRowHandler constructor.
     * @param string $classname
     * @throws ReflectionException
     */
    public function __construct(string $classname)
    {
        $this->classname = $classname;
        $this->reflection = new ReflectionClass($classname);
        foreach ($this->reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $this->lowerNames[strtolower($property->name)] = $property;
        }
    }

    public function __invoke(array $row)
    {
        $instance = $this->reflection->newInstance();
        $row = array_change_key_case($row);
        foreach ($this->lowerNames as $lowerName => $property) {
            if (array_key_exists($lowerName, $row)) {
                $property->setValue($instance, $row[$lowerName]);
            }
        }
        return $instance;
    }
}
