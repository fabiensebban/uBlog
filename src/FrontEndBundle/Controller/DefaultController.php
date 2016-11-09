<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
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
        $categories = $this->getDoctrine()
                    ->getRepository("AppBundle:Category")
                    ->findAll();
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        return $this->render('FrontEndBundle:Default:index.html.twig', array('categories' => $categories, 'routeName'=> $routeName));
    }

}
