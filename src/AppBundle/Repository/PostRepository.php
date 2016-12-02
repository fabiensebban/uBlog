<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
	public function getUserPosts($userId, $limit = null)
	{
		$query = "SELECT p FROM AppBundle:Post p WHERE p.author = ".$userId." ORDER BY p.created DESC";
		if ($limit) {
			$query .= " LIMIT ".$limit;
		}

		return $this->getEntityManager()
            		->createQuery($query)
            		->getResult();
	}

	//get likes & shares count of user
	public function getUserPostsRecap($userId)
	{
		$query = "SELECT SUM(p.likes) AS count_likes, SUM(p.shares) AS count_shares  
				  FROM AppBundle:Post p 
				  WHERE p.author = ". $userId;
		
		return $this->getEntityManager()
            		->createQuery($query)
            		->getSingleResult();
	}
}
