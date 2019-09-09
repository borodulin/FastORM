<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


class PlaylistTrack
{
    private $playlistId;
    private $trackId;
    /**
     * @var Playlist
     */
    private $playlist;
    /**
     * @var Track
     */
    private $track;
}
