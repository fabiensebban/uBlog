<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Post controller.
 */
class PostController extends Controller
{
    /**
     * Show a post entry
     */
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:post')->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Unable to find post.');
        }

        $comments = $em->getRepository('AppBundle:Comment')
            ->getCommentsForBlog($post->getId());

        return $this->render('AppBundle:Post:show.html.twig', array(
            'post'      => $post,
            'comments'  => $comments
        ));
    }
}