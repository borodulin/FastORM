<?php

declare(strict_types=true);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;
use SplStack;

class FromClause implements ClauseInterface
{
    use ClauseTrait {
        ClauseTrait::__construct as private clauseTraitConstruct;
    }

    private $from;

    public function __construct(QueryInterface $query)
    {
        $this->clauseTraitConstruct($query);
        $this->from = new SplStack();
    }

//    private function quoteTableNames($tables, &$params)
//    {
//        foreach ($tables as $i => $table) {
//            if ($table instanceof Query) {
//                list($sql, $params) = $this->build($table, $params);
//                $tables[$i] = "($sql) " . $this->db->quoteTableName($i);
//            } elseif (is_string($i)) {
//                if (strpos($table, '(') === false) {
//                    $table = $this->db->quoteTableName($table);
//                }
//                $tables[$i] = "$table " . $this->db->quoteTableName($i);
//            } elseif (strpos($table, '(') === false) {
//                if (preg_match('/^(.*?)(?i:\s+as|)\s+([^ ]+)$/', $table, $matches)) { // with alias
//                    $tables[$i] = $this->db->quoteTableName($matches[1]) . ' ' . $this->db->quoteTableName($matches[2]);
//                } else {
//                    $tables[$i] = $this->db->quoteTableName($table);
//                }
//            }
//        }
//
//        return $tables;
//    }

    public function addFrom($from): void
    {
        $alias = new AliasClause($this->getQuery());
        $alias->setExpression($from);
        $this->from->push($alias);
    }

    public function setAlias($alias): void
    {
        /** @var AliasClause $alias */
        $aliasClause = $this->from->current();
        $aliasClause->setAlias($alias);
    }
}
