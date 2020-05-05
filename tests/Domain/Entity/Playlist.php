<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\Domain\Entity;

class Playlist
{
    /**
     * @var int
     */
    private $playlistId;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var Track[]|null
     */
    private $tracks;

    public function getPlaylistId(): int
    {
        return $this->playlistId;
    }

    public function setPlaylistId(int $playlistId): self
    {
        $this->playlistId = $playlistId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Track[]|null
     */
    public function getTracks(): ?array
    {
        return $this->tracks;
    }

    /**
     * @param Track[]|null $tracks
     */
    public function setTracks(?array $tracks): self
    {
        $this->tracks = $tracks;

        return $this;
    }
}
