<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;
use SplStack;

class FromClause implements ExpressionInterface
{
    /**
     * @var SplStack
     */
    private $from;
    /**
     * @var ClauseContainer
     */
    private $container;

    public function __construct(ClauseContainer $container)
    {
        $this->from = new SplStack();
        $this->container = $container;
    }

    public function addFrom($from): void
    {
        $alias = new AliasClause();
        $alias->setExpression($from);
        $this->from->add(0, $alias);
    }

    public function setAlias($alias): void
    {
        /** @var AliasClause $alias */
        $aliasClause = $this->from->bottom();
        $aliasClause->setAlias($alias);
    }

    public function getFrom(): SplStack
    {
        return $this->from;
    }

    public function __clone()
    {
        $this->from = clone $this->from;
    }
}
