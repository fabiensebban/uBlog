<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Post;
use AppBundle\Form\Type\PostType;
use AppBundle\Repository\CategoryRepository as Category;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="home")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')
                         ->getCategoriesWithPublicPost();

        if ($this->container->get('security.context')->getToken()->getUser()) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneById(1);

            $post = new Post();
            $post->setAuthor($user);

            $form = $this->createForm(new PostType(), $post);


            return $this->render('AppBundle:Default:index.html.twig', array('categories' => $categories, 'post' => $form->createView(), 'action' => $this->generateUrl('add_post')));
        }

        return $this->render('AppBundle:Default:index.html.twig', array('categories' => $categories, 'post' => ''));
    }

}
