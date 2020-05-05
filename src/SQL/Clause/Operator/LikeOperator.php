<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

class LikeOperator implements OperatorInterface
{
    private $column;
    private $value;

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }
}
