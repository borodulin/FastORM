<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class EqualOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $column;
    private $value;

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }
        if ($expression->value instanceof ExpressionInterface || \is_array($expression->value)) {
            return $this->compiler->compile(new InOperator(
                $expression->column,
                $expression->value
            ));
        }
        $paramName = $this->compiler->getParams()->bindValue($expression->value);
        $column = $this->compiler->quoteColumnName($expression->column);

        return "$column = :$paramName";
    }
}
