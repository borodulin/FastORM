<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\Domain\Entity;

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

    public function getArtistId(): int
    {
        return $this->artistId;
    }

    public function setArtistId(int $artistId): self
    {
        $this->artistId = $artistId;

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
    public function setAlbums(array $albums): self
    {
        $this->albums = $albums;

        return $this;
    }
}
