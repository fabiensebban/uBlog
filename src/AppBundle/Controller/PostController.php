<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Form\Type\PostType;

/**
 * Class CommentController
 *
 * @package AppBundle\Controller
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
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Unable to find post.');
        }
/*
        $comments = $em->getRepository('AppBundle:Comment')
                        ->getCommentsForBlog($post->getId());
*/
        $categories = $this->getDoctrine()
            ->getRepository("AppBundle:Category")
            ->findAll();

        return $this->render('AppBundle:Post:show.html.twig', array(
                'post'          => $post,
                'allCategories' => $categories,
                //'comments'  => $comments
            ));
    }

    /**
     * @Route(
     *      "/post/add",
     *      name="add_post"
     * )
     *  @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $post = new Post();
        $post->setAuthor($user);

        //By default, A post is not published but it's approved.
        //Nobody except the admin can access to a not approved post
        $post->setIsPublished(false);
        $post->setIsApproved(true);

        $form = $this->createForm(new PostType(), $post);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->persist($post);
                $em->flush();

                return $this->redirectToRoute('show_post', array('id' => $post->getId(), 'slug' => $post->getSlug()));
            }
        }
    }

}
