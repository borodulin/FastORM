<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


class Album
{
    /**
     * @var int
     */
    private $albumId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var int
     */
    private $artistId;
    /**
     * @var Artist
     */
    private $artist;
    /**
     * @var Track[]
     */
    private $tracks;

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     */
    public function setArtist(Artist $artist): void
    {
        $this->artist = $artist;
    }

    /**
     * @return Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @param Track[] $tracks
     */
    public function setTracks(array $tracks): void
    {
        $this->tracks = $tracks;
    }
}
