<?php


namespace FastOrm\Fetch;

interface FetchColumnInterface
{
    public function column($num = 0): array;
}
