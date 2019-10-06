<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Repository;

use FastOrm\ConnectionInterface;
use FastOrm\ORM\Repository;
use FastOrm\Tests\Domain\Entity\Album;

class AlbumRepository extends Repository
{
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct(Album::class, 'Album', $connection);
    }

    public function byArtist($artistId): self
    {
        ($clone = clone $this)
            ->getSelectQuery()->where()->equal('ArtistId', $artistId);
        return $clone;
    }
}
