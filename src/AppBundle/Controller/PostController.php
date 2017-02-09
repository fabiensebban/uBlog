<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Config\Definition\Exception\Exception;
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

        $categories = $this->getDoctrine()
            ->getRepository("AppBundle:Category")
            ->findAll();

        return $this->render('AppBundle:Post:show.html.twig', array(
                'post'          => $post,
                'allCategories' => $categories,
                'comments'  => $post->getComments()->getValues()
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
        return $this->redirectToRoute('home');
    }

    /**
     * @Route(
     *      "/list_post/{id_category}",
     *      name="list_post"
     * )
     * @Method({"GET"})
     */
    public function categoryPostListAction($id_category)
    {
        $em = $this->getDoctrine()->getManager();

        $postsFromCategory = $em->getRepository('AppBundle:Post')
                          ->getPostsByCategory($id_category);
        $categories = $em->getRepository('AppBundle:Category')
                             ->getCategoriesWithPublicPost();
        $postsCategory = $em->getRepository('AppBundle:Category')
            ->getCategoryById($id_category);

        return $this->render('AppBundle:Post:listPost.html.twig', array(
                'allPosts' => $postsFromCategory,
                'allCategory' => $categories,
                'category' => $postsCategory
            ));
    }

    /**
     * @Route(
     *      "/search-by-tag",
     *      name="search_by_tag"
     * )
     *  @Method({"POST"})
     */
    public function searchByTagAction(Request $request)
    {
        try {
            $tag_string = $request->request->get('tags_string');

            $em = $this->getDoctrine()->getManager();

            $posts = $em->getRepository('AppBundle:Post')
                        ->getPostByTag($tag_string);
            $categories = $em->getRepository('AppBundle:Category')
                ->getCategoriesWithPublicPost();

            return $this->render('AppBundle:Post:listPost.html.twig', array(
                    'allPosts' => $posts,
                    'allCategory' => $categories,
                    'tags' => $tag_string
                ));
        }
        catch(Exception $e)
        {
            return $this->redirect('home');
        }

    }
}
