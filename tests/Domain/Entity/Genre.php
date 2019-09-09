<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


class Genre
{
    /**
     * @var int
     */
    private $genreId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Track[]
     */
    private $tracks;
}
