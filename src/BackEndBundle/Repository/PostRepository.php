<?php

namespace BackEndBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
* 
*/
class PostRepository extends EntityRepository
{

    public function getPost($post_id)
    {
    	$qb = $this->createQueryBuilder('p')
                   ->select('p, c')
                   ->leftJoin('p.comments', 'c');
    }
}