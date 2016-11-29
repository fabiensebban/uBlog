<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function getCategories()
    {

        return $this->createQueryBuilder('c')
                    ->select('c', 'p')
                    ->leftJoin('c.posts', 'p')
                    ->where('p.isPublished = true')
                    ->andWhere('p.isApproved = true')
                    ->getQuery()
                    ->getResult();

    }
}
