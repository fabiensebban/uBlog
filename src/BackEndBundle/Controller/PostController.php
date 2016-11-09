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

        $form = $this->createForm(new PostType(), $post, array(
	        'action' => $this->generateUrl('bo_show_post', array('id' => $id)),
	        'method' => 'PUT'
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

        		// $image = $post->getImage();
        		// $imageName = $this->get('app.image_uploader')->upload($image);
	         //    $post->setImage($imageName);
        		//var_dump($post->getImage());die();
	        	$em->persist($post);
	        	$em->flush();

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

        $form = $this->createForm(new PostType(), $post);
        //$form->handleRequest($request);
		$form->submit($request->request->get($form->getName()));

        if ($form->isSubmitted()) {	
        	if ($form->isValid()) {
        		$em->persist($post);
            	$em->flush();

            	return $this->redirectToRoute('bo_show_post', array('id' => $id));
        	}
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
    }

}