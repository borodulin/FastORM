<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


class Playlist
{
    private $playlistId;
    private $name;
    /**
     * @var Track[]
     */
    private $tracks;
}
