<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


class Artist
{
    /**
     * @var int
     */
    private $artistId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Album[]
     */
    private $albums;

    /**
     * @return Album[]
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    /**
     * @param Album[] $albums
     */
    public function setAlbums(array $albums): void
    {
        $this->albums = $albums;
    }

}
