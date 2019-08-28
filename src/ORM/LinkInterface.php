<?php


namespace FastOrm\ORM;


interface LinkInterface
{
    public function link($link): EntityQueryInterface;
}
