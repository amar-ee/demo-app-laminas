<?php

declare(strict_types=1);

namespace Album\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Album\Entity\Album;
use Album\Repository\AlbumRepository;

class AlbumService
{
    /**
     * @var AlbumRepository
     */
    private $albumRepository;

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param AlbumRepository $albumRepository
     * @param EntityManager $entityManager
     */
    public function __construct(AlbumRepository $albumRepository, EntityManager $entityManager)
    {
        $this->albumRepository = $albumRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Query
     */
    public function findAllAlbums():Query
    {
        return $this->albumRepository->findAllAlbums();
    }

    /**
     * @param Album $album
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveAlbum(Album $album): bool
    {
        $this->entityManager->persist($album);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param int $id
     * @return Album|null
     */
    public function findOneById(int $id): ?Album
    {
        return $this->albumRepository->find($id);
    }

    /**
     * @param Album $album
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAlbum(Album $album): bool
    {
        $this->entityManager->remove($album);
        $this->entityManager->flush();

        return true;
    }
}
