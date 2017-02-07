<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Swift_Message;

/**
 * Class CommentController
 *
 * @package AppBundle\Controller
 * @Route("/")
 */
class PageController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="add_post"
     * )
     * @Method({"GET"})
     */

    public function indexAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        $categories = $this->getDoctrine()->getRepository("AppBundle:Category")->findAll();
        return $this->render('AppBundle:Page:index.html.twig', array(
            'categories' => $categories,
            'routeName' => $routeName
        ));
    }

    /**
     * @Route(
     *      "/about",
     *      name="about")
     * @Method({"GET"})
     */
    public function aboutAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        return $this->render('AppBundle:Page:about.html.twig', array(
            'routeName' => $routeName
        ));
    }

    /**
     * @Route(
     *      "/contact",
     *      name="contact")
     */
    public function contactAction()
    {
        $request = $this->container->get('request');

        if ($this->getRequest()->isMethod('POST'))
        {
            $this->sendMail($this->getUser()->getEmail(),$request->request->get('object'),$request->request->get('message'));
        }


        return $this->render(
            'AppBundle:Page:contact.html.twig', array(
                'routeName' => ''
            )
        );
    }

    /**
     * @Route("/show_profile")
     * @Method({"GET"})
     */
    public function showprofileAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');

        return $this->render('AppBundle:Page:showUser.html.twig', array(
            'routeName' => $routeName
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

        return $this->render('AppBundle:Page:detailsPost.html.twig', array(
            'detailsPost' => $resultPost,
            'allCategory' => $resultCategory
        ));
    }

    private function sendMail($from, $object, $messageToSend)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($object)
            ->setFrom($from)
            ->setTo('scarpa.zend@gmail.com')
            ->setBody($messageToSend);

        $this->get('mailer')->send($message);
    }
}
