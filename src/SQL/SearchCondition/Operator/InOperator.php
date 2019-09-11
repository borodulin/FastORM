<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

/**
 * Class InOperator
 * @package FastOrm\SQL\Operator
 */
class InOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    ParamsAwareInterface
{
    use CompilerAwareTrait, ParamsAwareTrait;

    private $column;
    private $values;

    /**
     * InOperator constructor.
     * @param $column
     * @param $values
     */
    public function __construct($column, $values)
    {
        $this->column = $column;
        $this->values = $values;
    }

    public function build(): string
    {
        $values = $this->values;
        $column = $this->compiler->quoteColumnName($this->column);

        if (empty($values)) {
            return '0=1';
        }

        if ($values instanceof ExpressionInterface) {
            $sql = $this->compiler->compile($values);
            if (strpos($sql, '(') !== 0) {
                $sql = "($sql)";
            }
            return "$column IN $sql";
        }

        $values = is_array($values) ? $values : (array)$values;


        $sqlValues = $this->buildValues($values);
        if (empty($sqlValues)) {
            return '0=1';
        }
        $values = implode(',', $sqlValues);

        return "$column IN ($values)";
    }

    private function buildValues(array $values)
    {
        $result = [];
        foreach ($values as $value) {
            if ($value instanceof ExpressionInterface) {
                $value = $this->compiler->compile($value);
            }
            $paramName = $this->params->bindValue($value);
            $result[] = ":$paramName";
        }
        return $result;
    }
}
