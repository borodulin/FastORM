<?php

declare(strict_types=1);

namespace Borodulin\ORM\ORM\Converter;

class ReflectionConverter
{
    /**
     * @var array
     */
    private $lowerNames = [];
    /**
     * @var string
     */
    private $classname;
    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * ClassRowHandler constructor.
     *
     * @throws \ReflectionException
     */
    public function __construct(string $classname)
    {
        $this->reflection = new \ReflectionClass($classname);
        $this->classname = $classname;
        foreach ($this->reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $this->lowerNames[strtolower($property->name)] = $property;
        }
    }

    public function __invoke(array $row): object
    {
        $instance = $this->reflection->newInstance();
        $row = array_change_key_case($row);
        foreach ($this->lowerNames as $lowerName => $property) {
            if (\array_key_exists($lowerName, $row)) {
                $property->setValue($instance, $row[$lowerName]);
            }
        }

        return $instance;
    }
}
