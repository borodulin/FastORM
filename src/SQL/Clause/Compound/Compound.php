<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Compound;

use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Operator\OperatorInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use SplStack;

class Compound implements
    ExpressionInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var SplStack
     */
    private $compounds;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->compounds = new SplStack();
        $this->connection = $connection;
    }

    public function and(): void
    {
        $this->compounds->add(0, new CompoundItem($this, 'AND'));
    }

    public function or(): void
    {
        $this->compounds->add(0, new CompoundItem($this, 'OR'));
    }

    public function setOperator(OperatorInterface $operator): self
    {
        $compoundItem = $this->getCompoundItem();
        $compoundItem->setOperator($operator);
        return $this;
    }

    public function getCompoundItem(): CompoundItem
    {
        if ($this->compounds->count() === 0) {
            $this->compounds->add(0, new CompoundItem($this, ''));
        }
        return $this->compounds->bottom();
    }

    /**
     * @return SplStack
     */
    public function getCompounds(): SplStack
    {
        return $this->compounds;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof Compound) {
            throw new InvalidArgumentException();
        }
        $conditions = [];
        $compounds = $expression->getCompounds();
        /** @var CompoundItem $compoundItem */
        foreach ($compounds as $compoundItem) {
            if ($text = $this->compiler->compile($compoundItem)) {
                if ($compoundString = $compoundItem->getCompoundString()) {
                    $conditions[] = $compoundString;
                }
                $conditions[] = $text;
            }
        }
        return $conditions ? ' (' . implode(' ', $conditions) . ') ' : '';
    }

    public function __clone()
    {
        $compounds = new SplStack();
        foreach ($this->compounds as $compoundItem) {
            $compounds->push(clone $compoundItem);
        }
        $this->compounds = $compounds;
    }
}
