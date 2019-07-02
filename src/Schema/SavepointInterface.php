<?php

declare(strict_types=true);

namespace FastOrm\Schema;

interface SavepointInterface
{
    public function createSavepoint($name): void;

    public function releaseSavepoint(string $name): void;

    public function rollBackSavepoint(string $name): void;
}
