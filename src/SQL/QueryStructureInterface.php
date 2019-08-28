<?php


namespace FastOrm\SQL;


use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Expression\SearchExpression;

interface QueryStructureInterface
{
    public function getSelect(): SelectClause;
    public function getFrom(): FromClause;
    public function getJoin(): JoinClause;
    public function getWhere(): SearchExpression;
    public function getGroupBy(): GroupByClause;
    public function getHaving(): SearchExpression;
    public function getOrderBy(): OrderByClause;
    public function getUnion(): UnionClause;
}
