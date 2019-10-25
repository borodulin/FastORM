<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


use FastOrm\ORM\EntityInterface;

class PlaylistTrack implements EntityInterface
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

    public static function getPrimaryKey(): array
    {
        return ['PlaylistId', 'TrackId'];
    }
}
