<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 *
 * @package BackEndBundle\Controller
 * @Route("/backoffice")
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('BackEndBundle:Default:index.html.twig');
    }
}
