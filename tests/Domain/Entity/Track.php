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
     * @var int|null
     */
    private $albumId;
    /**
     * @var int
     */
    private $mediaTypeId;
    /**
     * @var int|null
     */
    private $genreId;
    /**
     * @var string|null
     */
    private $composer;
    /**
     * @var int
     */
    private $milliseconds;
    /**
     * @var int|null
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

    public function getTrackId(): int
    {
        return $this->trackId;
    }

    public function setTrackId(int $trackId): self
    {
        $this->trackId = $trackId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }

    public function setAlbumId(?int $albumId): self
    {
        $this->albumId = $albumId;

        return $this;
    }

    public function getMediaTypeId(): int
    {
        return $this->mediaTypeId;
    }

    public function setMediaTypeId(int $mediaTypeId): self
    {
        $this->mediaTypeId = $mediaTypeId;

        return $this;
    }

    public function getGenreId(): ?int
    {
        return $this->genreId;
    }

    public function setGenreId(?int $genreId): self
    {
        $this->genreId = $genreId;

        return $this;
    }

    public function getComposer(): ?string
    {
        return $this->composer;
    }

    public function setComposer(?string $composer): self
    {
        $this->composer = $composer;

        return $this;
    }

    public function getMilliseconds(): int
    {
        return $this->milliseconds;
    }

    public function setMilliseconds(int $milliseconds): self
    {
        $this->milliseconds = $milliseconds;

        return $this;
    }

    public function getBytes(): ?int
    {
        return $this->bytes;
    }

    public function setBytes(?int $bytes): self
    {
        $this->bytes = $bytes;

        return $this;
    }

    public function getUnitPrice(): string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function setAlbum(Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getMediaType(): MediaType
    {
        return $this->mediaType;
    }

    public function setMediaType(MediaType $mediaType): self
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
