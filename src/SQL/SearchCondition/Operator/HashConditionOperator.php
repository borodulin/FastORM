<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ParamsBinderAwareInterface;
use FastOrm\SQL\ParamsBinderAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class HashConditionOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    ParamsBinderAwareInterface
{
    use CompilerAwareTrait, ParamsBinderAwareTrait;
    /**
     * @var array
     */
    private $hash;

    /**
     * HashConditionOperator constructor.
     * @param $hash
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }

    public function build(): string
    {
        $hash = $this->hash;
        $parts = [];
        foreach ($hash as $column => $value) {
            if ($value instanceof ExpressionInterface || is_array($value)) {
                $parts[] = $this->compiler->compile(new InOperator($column, $value));
            } else {
//                if (strpos($column, '(') === false) {
//                    $column = $this->queryBuilder->db->quoteColumnName($column);
//                }
                if ($value === null) {
                    $parts[] = "$column IS NULL";
                } else {
                    $this->paramsBinder->bindValue($value, $paramName);
                    $parts[] = "$column=:$paramName";
                }
            }
        }
        return count($parts) === 1 ? $parts[0] : '(' . implode(') AND (', $parts) . ')';
    }
}
