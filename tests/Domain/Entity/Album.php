<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\Domain\Entity;

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

    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    public function setAlbumId(int $albumId): self
    {
        $this->albumId = $albumId;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtistId(): int
    {
        return $this->artistId;
    }

    public function setArtistId(int $artistId): self
    {
        $this->artistId = $artistId;

        return $this;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    public function setArtist(Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
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
    public function setTracks(array $tracks): self
    {
        $this->tracks = $tracks;

        return $this;
    }
}
