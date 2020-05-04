<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;

class MediaType
{
    /**
     * @var int
     */
    private $mediaTypeId;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var Track[]|null
     */
    private $tracks;

    public function getMediaTypeId(): int
    {
        return $this->mediaTypeId;
    }

    public function setMediaTypeId(int $mediaTypeId): self
    {
        $this->mediaTypeId = $mediaTypeId;

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
