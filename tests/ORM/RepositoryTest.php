<?php

declare(strict_types=1);

namespace FastOrm\Tests\ORM;

use FastOrm\ORM\Repository;
use FastOrm\Tests\Domain\Entity\Album;
use FastOrm\Tests\Domain\Entity\PlaylistTrack;
use FastOrm\Tests\Domain\Repository\AlbumRepository;
use FastOrm\Tests\TestCase;
use ReflectionException;

class RepositoryTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testIsset()
    {
        $repository = new Repository(Album::class, 'Album', $this->connection);
        $this->assertTrue(isset($repository[1]));
        $repository = new Repository(PlaylistTrack::class, 'PlaylistTrack', $this->connection);
        $this->assertTrue(isset($repository['1,1']));
    }

    /**
     * @throws ReflectionException
     */
    public function testRepoFilter()
    {
        $albumsRepository = new AlbumRepository($this->connection);
        $this->assertTrue(isset($albumsRepository[1]));
        $acdc = $albumsRepository->byArtist(1);
        $this->assertTrue(isset($acdc[1]));
        $this->assertFalse(isset($acdc[2]));
    }

    /**
     * @throws ReflectionException
     */
    public function testRowHandler()
    {
        $albumsRepository = new AlbumRepository($this->connection);
        $album = $albumsRepository[1];
        $this->assertInstanceOf(Album::class, $album);
    }
}
