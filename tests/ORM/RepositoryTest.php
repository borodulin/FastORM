<?php

declare(strict_types=1);

namespace FastOrm\Tests\ORM;

use FastOrm\NotSupportedException;
use FastOrm\ORM\Repository;
use FastOrm\Tests\Domain\Entity\Album;
use FastOrm\Tests\Domain\Entity\PlaylistTrack;
use FastOrm\Tests\Domain\Repository\AlbumRepository;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class RepositoryTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     * @throws ReflectionException
     */
    public function testIsset()
    {
        $repository = new Repository(Album::class, 'albums', $this->createConnection());
        $this->assertTrue(isset($repository[1]));
        $repository = new Repository(PlaylistTrack::class, 'playlist_track', $this->createConnection());
        $this->assertTrue(isset($repository['1,1']));
    }

    /**
     * @throws NotSupportedException
     * @throws ReflectionException
     */
    public function testRepoFilter()
    {
        $connection = $this->createConnection();
        $albumsRepository = new AlbumRepository($connection);
        $this->assertTrue(isset($albumsRepository[1]));
        $acdc = $albumsRepository->byArtist(1);
        $this->assertTrue(isset($acdc[1]));
        $this->assertFalse(isset($acdc[2]));
    }

    /**
     * @throws NotSupportedException
     * @throws ReflectionException
     */
    public function testRowHandler()
    {
        $connection = $this->createConnection();
        $albumsRepository = new AlbumRepository($connection);
        $album = $albumsRepository[1];
        $this->assertInstanceOf(Album::class, $album);
    }
}
