<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CommentController
 *
 * @package FrontEndBundle\Controller
 * @Route("/")
 */
class PostController extends Controller
{
    /**
     * @Route(
     *     "/post/{id}/{slug}",
     *     name="show_post",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"GET"})
     */
    public function showAction($id, $slug)
    {
        return $this->render('FrontEndBundle:Post:show.html.twig', array(
            // ...
        ));
    }

}
