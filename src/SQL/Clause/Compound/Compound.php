<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Compound;

use Borodulin\ORM\ConnectionInterface;
use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\Operator\OperatorInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
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
        if (0 === $this->compounds->count()) {
            $this->compounds->add(0, new CompoundItem($this, ''));
        }

        return $this->compounds->bottom();
    }

    public function getCompounds(): SplStack
    {
        return $this->compounds;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
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

        return $conditions ? ' ('.implode(' ', $conditions).') ' : '';
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
