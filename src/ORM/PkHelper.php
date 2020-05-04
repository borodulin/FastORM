<?php

declare(strict_types=1);

namespace FastOrm\ORM;

class PkHelper
{
    public static function getAsHash(string $entityClass, $pk): array
    {
        /** @var EntityInterface $entityClass */
        $primaryKey = $entityClass::getPrimaryKey();
        $pk = explode(',', (string) $pk);

        return $hash = array_combine($primaryKey, (array) $pk);
    }
}
