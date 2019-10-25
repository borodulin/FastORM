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
        $repository = new Repository(PlaylistTrack::class, 'PlaylistTrack', $this->db);
        $this->assertTrue(isset($repository['1,1']));
        $repository = new Repository(Album::class, 'Album', $this->db);
        $this->assertTrue(isset($repository[1]));
    }

    /**
     * @throws ReflectionException
     */
    public function testRepoFilter()
    {
        $albumsRepository = new AlbumRepository($this->db);
        $this->assertTrue(isset($albumsRepository[1]));
        $acdc = $albumsRepository->byArtist(1)->toArray();
        $this->assertTrue(isset($acdc[1]));
        $this->assertFalse(isset($acdc[2]));
        $this->assertTrue(isset($albumsRepository[2]));
    }

    /**
     * @throws ReflectionException
     */
    public function testRepoArray()
    {
        $albumsRepository = new AlbumRepository($this->db);
        $acdc = $albumsRepository->byArtist(1);
        $rows = iterator_to_array($acdc);
        $this->assertIsArray($rows);
    }

    /**
     * @throws ReflectionException
     */
    public function testRowHandler()
    {
        $albumsRepository = new AlbumRepository($this->db);
        $album = $albumsRepository[1];
        $this->assertInstanceOf(Album::class, $album);
    }
}
