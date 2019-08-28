<?php

declare(strict_types=1);

namespace FastOrm\ORM\Entity;

trait EntityTrait
{
    abstract public function getPrimaryKey(): string;

    /**
     * Produces a scalar value to be used as the object's hash, which determines
     * where it goes in the hash table. While this value does not have to be
     * unique, objects which are equal must have the same hash value.
     *
     * @return mixed
     */
    public function hash()
    {
        return static::class . '#' . $this->getPrimaryKey();
    }

    /**
     * Determines if two objects should be considered equal. Both objects will
     * be instances of the same class but may not be the same instance.
     *
     * @param $obj self An instance of the same class to compare to.
     *
     * @return bool
     */
    public function equals($obj): bool
    {
        return $obj->hash() === $this->hash();
    }
}
