<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CommentController
 *
 * @package AppBundle\Controller
 * @Route("/")
 */
class CommentController extends Controller
{
    /**
     * @Route("/comment/create")
     * @Method({"POST"})
     */
    public function createAction()
    {
        return $this->render('AppBundle:Comment:create.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/comment/{id}/like")
     * @Method({"POST"})
     */
    public function likeAction($id)
    {
        return $this->render('AppBundle:Comment:like.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/comment/{id}/share")
     * @Method({"POST"})
     */
    public function shareAction($id)
    {
        return $this->render('AppBundle:Comment:share.html.twig', array(
            // ...
        ));
    }

}
