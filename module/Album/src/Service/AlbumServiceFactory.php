<?php

declare(strict_types=1);

namespace Album\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Album\Entity\Album;

class AlbumServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AlbumService
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AlbumService
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $albumRepository = $entityManager->getRepository(Album::class);

        return new AlbumService($albumRepository, $entityManager);
    }
}
