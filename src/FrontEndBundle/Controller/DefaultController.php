<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Post;


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

        if ($this->container->get('security.context')->getToken()->getUser()) {
            $post = $this->createFormBuilder()
                ->add('title')
                ->add('body')
                ->add('image', 'sonata_media_type', array(
                        'provider' => 'sonata.media.provider.image',
                        'context'  => 'default'
                    ))
                ->add('save', SubmitType::class)
                ->getForm();

            return $this->render('FrontEndBundle:Default:index.html.twig', array('categories' => $categories, 'post' => $post->createView()));
        }

        return $this->render('FrontEndBundle:Default:index.html.twig', array('categories' => $categories, 'post' => ''));
    }

}
