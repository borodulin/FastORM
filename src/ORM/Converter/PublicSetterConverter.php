<?php

declare(strict_types=1);

namespace Borodulin\ORM\ORM\Converter;

class PublicSetterConverter
{
    /**
     * @var int
     */
    private $test;

    public function getTest(): int
    {
        return $this->test;
    }

    public function setTest(int $test): self
    {
        $this->test = $test;

        return $this;
    }
}
