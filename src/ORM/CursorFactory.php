<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\ORM\CursorHandler\EntityHandler;
use FastOrm\PdoCommand\Fetch\BatchCursor;
use FastOrm\PdoCommand\Fetch\CursorFactoryInterface;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use PDO;
use PDOStatement;
use ReflectionException;

class CursorFactory implements CursorFactoryInterface
{
    /**
     * @var string
     */
    private $entityClass;

    public function __construct(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @param PDOStatement $statement
     * @param int $fetchStyle
     * @return CursorInterface
     * @throws ReflectionException
     */
    public function create(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC): CursorInterface
    {
        /** @var EntityInterface $className */
        $className = $this->entityClass;
        return (new BatchCursor($statement, $fetchStyle))
            ->setRowHandler(new EntityHandler($this->entityClass));
    }
}
