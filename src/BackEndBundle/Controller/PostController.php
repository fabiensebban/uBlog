<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use BackEndBundle\Form\Type\PostType;
use AppBundle\Entity\Post;

/**
 * @Route("/bo")
 */
class PostController extends Controller
{
    /**
     * @Route(
     *     "/post/{id}",
     *     name="bo_show_post",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"GET"})
     */
    public function showAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->findOneById($id);

        $form = $this->createForm(PostType::class, $post, array(
	        'action' => $this->generateUrl('bo_update_post', array('id' => $id)),
	        'method' => 'PUT',
            'update' => true
    	));

        return $this->render('BackEndBundle:Post:show.html.twig', array(
        	'post'	=>	$post,
        	'form'  =>  $form->createView()
        ));
    }

    /**
     * @Route(
     *     "/post/add",
     *     name="bo_add_post"
     * )
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('AppBundle:User')->findOneById(1);
    	
    	$post = new Post();
    	$post->setAuthor($user);
        
        $form = $this->createForm(new PostType(), $post);

        if ($request->isMethod('POST')) {
    		$form->handleRequest($request);

        	if ($form->isSubmitted() && $form->isValid()) {

                if(!$request->request->get('publish')) {
                    $post->setIsPublished(false); //the post is published by default 
                }
                
	        	$em->persist($post);
	        	$em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Your post has been created !');

	        	return $this->redirectToRoute('bo_show_post', array('id' => $post->getId()));
        	}
        }

        return $this->render('BackEndBundle:Post:add.html.twig', array(
        	'form'  =>  $form->createView()
        ));
    }

    /**
     * @Route(
     *     "/post/{id}",
     *     name="bo_update_post",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	// Check if post exist
		if (!$post = $em->getRepository('AppBundle:Post')->findOneById($id)) {
			throw new NotFoundHttpException(
				$this->get('translator')->trans('This post does not exist.')
			);
		}

        $current_img = $post->getImage()->getFileName();

        $form = $this->createForm(PostType::class, $post, array(
            'action' => $this->generateUrl('bo_update_post', array('id' => $id)),
            'method' => 'PUT',
            'update' => true
        ));

        $form->handleRequest($request);

        // if image NOT updated set current one
        if (!$post->getImage()){
            $post->setImage($current_img);
        }

        if ($form->isSubmitted()) {
            if($request->request->get('publish')) {
                $post->setIsPublished(true);
            }
            else {
                $post->setIsPublished(false);
            }

            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your post has been updated !');

            return $this->redirectToRoute('bo_show_post', array('id' => $id));
        }

    }

    /**
     * @Route(
     *     "/post/{id}/delete",
     *     name="bo_delete_post",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	// Check if post exist
		if (!$post = $em->getRepository('AppBundle:Post')->findOneById($id)) {
			throw new NotFoundHttpException(
				$this->get('translator')->trans('This post does not exist.')
			);
		}

    	$em->remove($post);
		$em->flush();

        // redirect to the "bo_index" route if DELETE Ok
        return $this->redirectToRoute('bo_index');
    }

}