<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CommentController
 *
 * @package FrontEndBundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('FrontEndBundle:Default:index.html.twig');
    }
}
