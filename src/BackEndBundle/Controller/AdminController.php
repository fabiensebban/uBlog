<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @Route(
     *     "/posts",
     *     name="admin_posts_list"
     * )
     * @Method({"GET"})
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findAll();
        $recap = $em->getRepository('AppBundle:Post')->getPostsRecap();

        return $this->render('BackEndBundle:Index:admin.html.twig', array(
            'posts' =>  $posts,
            'likes_count' => $recap['count_likes'],
            'shares_count' => $recap['count_shares']
        ));
    }

    /**
     * @Route(
     *     "/post/approve/{id}",
     *     name="admin_approve_post",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function approveAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->findOneById($id);
        $post->setImage($post->getImage()->getFileName());
        //toggle status
        $post->setIsApproved(!$post->getIsApproved());
        $em->flush();
        //response
        $data = array('status' => $post->getIsApproved());
        return new JsonResponse($data);
    }

    /**
     * @Route(
     *     "/categories",
     *     name="admin_categories"
     * )
     * @Method({"GET"})
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        //dump($categories);die();
        return $this->render('BackEndBundle:Category:index.html.twig', array(
            'categories' =>  $categories
        ));
    }

    /**
     * @Route(
     *     "/category/add",
     *     name="admin_category_add"
     * )
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = new Category();

        if ($name = $request->request->get('name')) {
            $cat->setDisplayName($name);
            $cat->setNameId(strtolower($name));

            $em->persist($cat);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'The category has been created !');

            return $this->redirectToRoute('admin_categories');
        }
        else {
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'The category is not valid ! Verify category value.');

            return $this->redirectToRoute('admin_categories');
        }
    }

    /**
     * @Route(
     *     "/category/{id}",
     *     name="admin_update_category",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        // Check if category exist
        if (!$cat = $em->getRepository('AppBundle:Category')->findOneById($id)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This category does not exist.')
            );
        }

        if ($name = $request->request->get('name'))
        {
            $cat->setDisplayName($name);
            $em->flush();
            //response
            $data = array('status' => 1);
            return new JsonResponse($data);            
        }
        else {
            //response
            $data = array('status' => false);
            return new JsonResponse($data); 
        }
    }

    /**
     * @Route(
     *     "/category/{id}/delete",
     *     name="admin_delete_category",
     *     requirements={"id": "\d+"}
     * )
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        // Check if category exist
        if (!$cat = $em->getRepository('AppBundle:Category')->findOneById($id)) {
            throw new NotFoundHttpException(
                $this->get('translator')->trans('This category does not exist.')
            );
        }

        $em->remove($cat);
        $em->flush();

        $request->getSession()
                ->getFlashBag()
                ->add('danger', 'The category has been deleted !');

        // redirect to the "categories index" route if DELETE Ok
        return $this->redirectToRoute('admin_categories');
    }
}