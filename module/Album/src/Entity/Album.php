<?php

declare(strict_types=1);

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="Album\Repository\AlbumRepository")
 */
class Album
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(name="artist", type="string", nullable=true)
     * @var string $artist
     */
    private $artist;

    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     * @var string $title
     */
    private $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $artist
     */
    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
    }
}
