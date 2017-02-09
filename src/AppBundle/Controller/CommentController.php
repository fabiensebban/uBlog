<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Comment;


/**
 * Class CommentController
 *
 * @package AppBundle\Controller
 * @Route("/")
 */
class CommentController extends Controller
{
    /**
     * @Route("/comment/create", name="comment_add")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {   
        //check if post exist
        $post_id = (int)$request->request->get('post_id');

        $em = $this->getDoctrine()->getManager();
        // Check if post exist
        if (!$post = $em->getRepository('AppBundle:Post')->findOneById($post_id)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This post does not exist.')
            );
        }

        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $cmt = new Comment();

        if ($content = $request->request->get('cmt_content')) {
        
            $cmt->setContent($content);
            $cmt->setAuthor($user);
            $cmt->setLikes(1);

            $current_img = $post->getImage()->getFileName();
            $post->setImage($current_img);
            $cmt->setPost($post);
            
            $em->persist($cmt);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'The comment has been added !');
        }
        else {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'The comment content is not valid !');
        }

        return $this->redirectToRoute('show_post', array('id' => $post->getId(), 'slug' => $post->getSlug()));
    }

}
