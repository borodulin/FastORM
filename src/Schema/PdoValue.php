<?php

declare(strict_types=true);

namespace FastOrm\Schema;

final class PdoValue
{
    private $value;
    /**
     * @var int
     */
    private $type;

    public function __construct($value, int $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}
