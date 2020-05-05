<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\Domain\Entity;

class PlaylistTrack
{
    /**
     * @var int
     */
    private $playlistId;
    /**
     * @var int
     */
    private $trackId;
    /**
     * @var Playlist
     */
    private $playlist;
    /**
     * @var Track
     */
    private $track;

    public function getPlaylistId(): int
    {
        return $this->playlistId;
    }

    public function setPlaylistId(int $playlistId): self
    {
        $this->playlistId = $playlistId;

        return $this;
    }

    public function getTrackId(): int
    {
        return $this->trackId;
    }

    public function setTrackId(int $trackId): self
    {
        $this->trackId = $trackId;

        return $this;
    }

    public function getPlaylist(): Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getTrack(): Track
    {
        return $this->track;
    }

    public function setTrack(Track $track): self
    {
        $this->track = $track;

        return $this;
    }
}
