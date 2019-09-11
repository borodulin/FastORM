<?php

declare(strict_types=1);

namespace FastOrm\Command;

use PDO;

class Params implements ParamsInterface
{
    const PARAM_PREFIX = 'p';

    private $params = [];
    private $counter = 0;

    public function bindAll(array $params): void
    {
        foreach ($params as $name => $value) {
            if (preg_match('/^[:@](.+)$/', $name, $matches)) {
                $name = $matches[1];
            }
            if ($value instanceof PdoValue) {
                $this->params[$name] = $value;
            } else {
                $type = $this->getPdoType($value);
                $this->params[$name] = new PdoValue($value, $type);
            }
        }
    }

    public function bindValue($value): string
    {
        if (is_string($value) && (preg_match('/^[@:](.+)$/', $value, $matches))) {
            $paramName = $matches[1];
            if (!isset($this->params[$paramName])) {
                $this->bindOne($paramName, null);
            }
        } else {
            $paramName = self::PARAM_PREFIX . ++$this->counter;
            $this->bindOne($paramName, $value);
        }
        return $paramName;
    }

    public function bindOne($name, $value, int $dataType = null): void
    {
        if ($dataType === null) {
            $dataType = $this->getPdoType($value);
        }
        $this->params[$name] = new PdoValue($value, $dataType);
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

    /**
     * @return PdoValue[]
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
