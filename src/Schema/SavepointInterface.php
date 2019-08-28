<?php

declare(strict_types=1);

namespace FastOrm\Schema;

interface SavepointInterface
{
    public function createSavepoint($name): void;

    public function releaseSavepoint(string $name): void;

    public function rollBackSavepoint(string $name): void;
}
