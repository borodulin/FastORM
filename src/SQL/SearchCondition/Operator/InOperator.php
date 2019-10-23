<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
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
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $column;
    private $values;

    /**
     * InOperator constructor.
     * @param $column
     * @param $values
     */
    public function __construct(string $column, $values)
    {
        $this->column = $column;
        $this->values = $values;
    }

    private function buildValues(array $values)
    {
        $result = [];
        foreach ($values as $value) {
            if ($value instanceof ExpressionInterface) {
                $value = $this->compiler->compile($value);
            }
            $paramName = $this->compiler
                ->getParams()
                ->bindValue($value);
            $result[] = ":$paramName";
        }
        return $result;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof InOperator) {
            throw new InvalidArgumentException();
        }
        $values = $expression->values;
        $column = $this->compiler->quoteColumnName($expression->column);

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
}
