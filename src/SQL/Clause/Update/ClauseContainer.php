<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\Compound\ClauseContainer as BaseClauseContainer;
use FastOrm\SQL\Clause\Compound\ConditionInterface;
use FastOrm\SQL\Clause\UpdateClauseInterface;

class ClauseContainer extends BaseClauseContainer implements
    UpdateClauseInterface,
    SetClauseInterface,
    WhereClauseInterface
{
    public function update(string $table): SetClauseInterface
    {
        return $this;
    }

    public function set(array $set): WhereClauseInterface
    {
        return $this;
    }

    public function where(): ConditionInterface
    {
        // TODO: Implement where() method.
        return $this;
    }

    public function __clone()
    {
        $this->compound = clone $this->compound;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    /**
     * @param array $options
     * @return StatementInterface
     */
    public function statement(array $options = []): StatementInterface
    {
        // TODO: Implement statement() method.
    }
}
