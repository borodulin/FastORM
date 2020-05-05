<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;

class LimitClause implements ExpressionInterface
{
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset): void
    {
        $this->offset = $offset;
    }
}
