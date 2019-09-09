<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;

class Track
{
    /**
     * @var int
     */
    private $trackId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $albumId;
    /**
     * @var int
     */
    private $mediaTypeId;
    /**
     * @var int
     */
    private $genreId;
    /**
     * @var string
     */
    private $composer;
    /**
     * @var int
     */
    private $milliseconds;
    /**
     * @var int
     */
    private $bytes;
    /**
     * @var string
     */
    private $unitPrice;

    /**
     * @var Album
     */
    private $album;

    /**
     * @var MediaType
     */
    private $mediaType;

    /**
     * @var Genre
     */
    private $genre;

    /**
     * @return Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum(Album $album): void
    {
        $this->album = $album;
    }

    /**
     * @return MediaType
     */
    public function getMediaType(): MediaType
    {
        return $this->mediaType;
    }

    /**
     * @param MediaType $mediaType
     */
    public function setMediaType(MediaType $mediaType): void
    {
        $this->mediaType = $mediaType;
    }

    /**
     * @return Genre
     */
    public function getGenre(): Genre
    {
        return $this->genre;
    }

    /**
     * @param Genre $genre
     */
    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;
    }
}
