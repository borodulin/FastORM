<?php


namespace FastOrm\Fetch;

interface IndexByInterface
{
    public function indexBy($column): FetchAllInterface;
}
