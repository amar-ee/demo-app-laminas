<?php

declare(strict_types=1);

namespace Album\Controller;

use Album\Hydrator\AlbumHydrator;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Album\Service\AlbumService;

class AlbumControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AlbumController
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AlbumController
    {
        return new AlbumController($container->get(AlbumService::class),$container->get(AlbumHydrator::class));
    }
}
