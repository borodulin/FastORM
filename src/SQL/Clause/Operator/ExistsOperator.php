<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\SelectClauseInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class ExistsOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    /**
     * @var SelectClauseInterface
     */
    private $query;

    public function __construct(SelectClauseInterface $query)
    {
        $this->query = $query;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }
        $sql = $this->compiler->compile($expression->query);

        return "EXISTS($sql)";
    }
}
