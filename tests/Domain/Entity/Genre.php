<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;

class Genre
{
    /**
     * @var int
     */
    private $genreId;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var Track[]|null
     */
    private $tracks;

    public function getGenreId(): int
    {
        return $this->genreId;
    }

    public function setGenreId(int $genreId): self
    {
        $this->genreId = $genreId;

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
