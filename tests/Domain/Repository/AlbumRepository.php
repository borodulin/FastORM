<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Repository;

use FastOrm\ConnectionInterface;
use FastOrm\ORM\Repository;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\Tests\Domain\Entity\Album;

class AlbumRepository extends Repository
{
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct(Album::class, 'Album', $connection);
    }

    public function byArtist($artistId): SelectClauseInterface
    {
        return $this->queryBuilder->select()
            ->where()->equal('ArtistId', $artistId);
    }
}
