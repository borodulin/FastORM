<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

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
     * @param array $hash
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof HashConditionOperator) {
            throw new InvalidArgumentException();
        }
        $hash = $expression->hash;
        if (empty($hash)) {
            return '';
        }
        $parts = [];
        foreach ($hash as $column => $value) {
            if (is_int($column)) {
                if ($value instanceof ExpressionInterface) {
                    $parts[] = $this->compiler->compile(new ExpressionOperator($value, []));
                }
//                elseif (is_array($value)) {
//
//                }
            } elseif ($value instanceof ExpressionInterface || is_array($value)) {
                $parts[] = $this->compiler->compile(new InOperator($column, $value));
            } else {
                $column = $this->compiler->quoteColumnName($column);

                if ($value === null) {
                    $parts[] = "$column IS NULL";
                } else {
                    $paramName = $this->compiler->getParams()->bindValue($value);
                    $parts[] = "$column=:$paramName";
                }
            }
        }
        return count($parts) === 1 ? $parts[0] : '(' . implode(') AND (', $parts) . ')';
    }
}
