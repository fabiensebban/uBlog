<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PageController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render('FrontEndBundle:Page:index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/about")
     * @Method({"GET"})
     */
    public function aboutAction()
    {
        return $this->render('FrontEndBundle:Page:about.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/contact")
     * @Method({"GET"})
     */
    public function contactAction()
    {
        return $this->render('FrontEndBundle:Page:contact.html.twig', array(
            // ...
        ));
    }

}
