<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class FilterHashConditionOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    /**
     * @var array
     */
    private $hash;

    /**
     * FilterHashOperator constructor.
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }
        $hash = array_filter($expression->hash);

        return $this->compiler->compile(new HashConditionOperator($hash));
    }
}
