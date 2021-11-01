<?php

declare(strict_types=1);

namespace Album\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class AlbumRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function findAllAlbums(): Query
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select()
                     ->orderBy('a.id', 'DESC');
        $query = $queryBuilder->getQuery();

        return $query;
    }
}
