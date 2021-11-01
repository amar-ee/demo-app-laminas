<?php

declare(strict_types=1);

namespace Album\Hydrator;

use Laminas\Hydrator\ClassMethodsHydrator;

class AlbumHydrator extends ClassMethodsHydrator
{
    /**
     * @param array $data
     * @param object $object
     * @return object|void
     */
    public function hydrate(array $data, object $object)
    {
        return parent::hydrate($data, $object);
    }

    /**
     * @param object $object
     * @return array
     */
    public function extract(object $object) : array
    {
        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'artist' => $object->getArtist(),
        ];
    }
}

