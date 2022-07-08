<?php

namespace App\Controller\Admin;


use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/post")
 */
class PostController extends AbstractController {

    /**
     * @Route("/", name="admin_post_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(PostRepository $post, Request $request)
    {

        $page = $request->get('page', 0);
        $keywords = $request->get('keywords');

        $offset = $page * PostRepository::PAGINATOR_PER_PAGE;
        $list = $post->getListPaginator($keywords, $offset);

        return $this->render('admin/post/index.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_post_show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Post $post)
    {
        dump($post);die;
    }

    /**
     * @Route("/{id}/edit", name="admin_post_edit")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Post $post)
    {
        dump($post);die;
    }

    /**
     * @Route("/{id}/delete", name="admin_post_delete")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Post $post, EntityManagerInterface $em)
    {
        $em->remove($post);
        //$em->flush();

        return $this->redirectToRoute('admin_post_index');
    }
}
