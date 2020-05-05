<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class HashConditionOperator implements
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
     * HashConditionOperator constructor.
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
        $hash = $expression->hash;
        if (empty($hash)) {
            return '';
        }
        $parts = [];
        foreach ($hash as $column => $value) {
            if (\is_int($column)) {
                if ($value instanceof ExpressionInterface) {
                    $parts[] = $this->compiler->compile(new ExpressionOperator($value, []));
                }
//                elseif (is_array($value)) {
//
//                }
            } elseif ($value instanceof ExpressionInterface || \is_array($value)) {
                $parts[] = $this->compiler->compile(new InOperator($column, $value));
            } else {
                $column = $this->compiler->quoteColumnName($column);

                if (null === $value) {
                    $parts[] = "$column IS NULL";
                } else {
                    $paramName = $this->compiler->getParams()->bindValue($value);
                    $parts[] = "$column=:$paramName";
                }
            }
        }

        return 1 === \count($parts) ? $parts[0] : '('.implode(') AND (', $parts).')';
    }
}
