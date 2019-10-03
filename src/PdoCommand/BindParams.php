<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand;

use PDO;
use PDOStatement;

class BindParams
{
    public function __invoke(PDOStatement $statement, array $params)
    {
        foreach ($params as $name => $value) {
            if ($value instanceof PdoValue) {
                $statement->bindValue($name, $value->getValue(), $value->getType());
            } else {
                $statement->bindValue($name, $value, $this->getPdoType($value));
            }
        }
    }

    protected function getPdoType($data)
    {
        static $typeMap = [
            // php type => PDO type
            'boolean' => PDO::PARAM_BOOL,
            'integer' => PDO::PARAM_INT,
            'string' => PDO::PARAM_STR,
            'resource' => PDO::PARAM_LOB,
            'NULL' => PDO::PARAM_NULL,
        ];
        $type = gettype($data);
        return $typeMap[$type] ?? PDO::PARAM_STR;
    }
}
