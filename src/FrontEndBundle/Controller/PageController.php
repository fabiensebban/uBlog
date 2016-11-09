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
class PageController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */

    public function indexAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        $categories = $this->getDoctrine()->getRepository("AppBundle:Category")->findAll();
        return $this->render('FrontEndBundle:Page:index.html.twig', array(
            'categories' => $categories,
            'routeName' => $routeName
        ));
    }

    /**
     * @Route("/about")
     * @Method({"GET"})
     */
    public function aboutAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        return $this->render('FrontEndBundle:Page:about.html.twig', array(
            'routeName' => $routeName
        ));
    }

    /**
     * @Route("/contact")
     * @Method({"GET"})
     */
    public function contactAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        return $this->render('FrontEndBundle:Page:contact.html.twig', array(
            'routeName' => $routeName
        ));
    }

    /**
     * @Route("/show_profile")
     * @Method({"GET"})
     */
    public function showprofileAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        return $this->render('FrontEndBundle:Page:showUser.html.twig', array(
            'routeName' => $routeName
        ));
    }

    /**
     * @Route("/list_post")
     * @Method({"GET"})
     */
    public function listpostAction()
    {
        $resultPosts = $this->getDoctrine()->getRepository('AppBundle\Entity\Post')->findAll();
        $resultCategory = $this->getDoctrine()->getRepository('AppBundle\Entity\Category')->findAll();

        return $this->render('FrontEndBundle:Page:listPost.html.twig', array(
            'allPosts' => $resultPosts,
            'allCategory' => $resultCategory
        ));
    }

    /**
     * @Route("/details/{id}", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function detailsAction($id)
    {
        $resultPost = $this->getDoctrine()->getRepository('AppBundle\Entity\Post')->find($id);
        $resultCategory = $this->getDoctrine()->getRepository('AppBundle\Entity\Category')->findAll();

        return $this->render('FrontEndBundle:Page:detailsPost.html.twig', array(
            'detailsPost' => $resultPost,
            'allCategory' => $resultCategory
        ));
    }
}
