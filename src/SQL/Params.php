<?php

declare(strict_types=1);

namespace FastOrm\SQL;

class Params implements ParamsInterface
{
    const PARAM_PREFIX = 'p';

    private $params = [];
    private $counter = 0;

    private $paramsPattern = '/^[:@](.+)$/';

    public function __construct(array $params = [])
    {
        $this->bindAll($params);
    }

    public function bindAll(array $params): void
    {
        foreach ($params as $name => $value) {
            if (preg_match($this->paramsPattern, $name, $matches)) {
                $name = $matches[1];
            }
            $this->params[$name] = $value;
        }
    }

    public function bindValue($value): string
    {
        if (is_string($value) && (preg_match($this->paramsPattern, $value, $matches))) {
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

    public function bindOne($name, $value): void
    {
        $this->params[$name] = $value;
    }
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
