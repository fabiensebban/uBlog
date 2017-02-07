<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class IndexController extends Controller
{
    /**
     * @Route(
     *     "/bo",
     *     name="bo_index"
     * )
     * @Method({"GET"})
     */
    public function indexAction()
    {
    	$userId = 1;
    	$em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->getUserPosts($userId);
        $recap = $em->getRepository('AppBundle:Post')->getPostsRecap($userId);

        return $this->render('BackEndBundle:Index:index.html.twig', array(
        	'posts'	=>	$posts,
        	'likes_count' => $recap['count_likes'],
        	'shares_count' => $recap['count_shares']
        ));
    }

}
