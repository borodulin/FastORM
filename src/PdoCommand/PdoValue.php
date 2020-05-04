<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand;

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

    public function getType(): int
    {
        return $this->type;
    }
}
