<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Post;
use App\Form\postForm;

//use App\Controller\ManagerRegistry;
use App\Repository\PostRepository;
use Doctrine\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Vitali Romanenko <vit.romanenko@gmail.com>
 */
class PostController extends AbstractController
{
    /**
     * @Route("/newpost", name="post_createPost")
     * @return response
     * description - method for creating new posts
     */
    public function createPost(ManagerRegistry $doctrine, Request $request ): Response
    {
        $mypost = new Post();
        $mypost->setName('new post from lesson#6');
        $mypost->setPublicAt(new \DateTime());

        $postFormNew=$this->createForm(postForm::class, $mypost);
        $postFormNew->handleRequest($request);
        if( $postFormNew->isSubmitted() && $postFormNew->isValid())
            {
                $entityManager_PA = $doctrine->getManager();
                $entityManager_PA->persist($mypost);
                $entityManager_PA->flush();
            }
        return $this->render('post/create.html.twig', [
                'post' => $mypost,
                'postFormNew' => $postFormNew->createView(),
            ]
        );
    }

    /**
     * @Route("/editPost/{id}", name="post_editMyPost")
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return response
     * description - method for edit new posts
     */
    public function editMyPost(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        // look for a single Product by id
        $mypost = $repository->find($id);

        $postFormNew=$this->createForm(postForm::class, $mypost);

        $postFormNew->handleRequest($request);
        if( $postFormNew->isSubmitted() && $postFormNew->isValid())
        {
            $entityManager_PA = $doctrine->getManager();
            $entityManager_PA->persist($mypost);
            $entityManager_PA->flush();
        }

        return $this->render('post/edit.html.twig', [
                'post' => $mypost,
                'postFormNew' => $postFormNew->createView(),
            ]
        );
    }
    /**
     * @Route("/showPost/{postId}", name="post_showPost")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * description - its method #1 fetching POST from DB (something SELECT) - P.S. default use IT method
     */

    public function showPost(ManagerRegistry $doctrine, int $postId): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $post_get = $repository->find($postId);
        //  это просто проверка на наличие такого номера
        if (!$post_get) {
            throw $this->createNotFoundException(
                'Hi guys, No post found for id'
            //                    . $id
            );
        }
        $post_get2 = $repository->findOneBy(['name' => 'Name my post №55']);
        $post_get3 = $repository->findOneBy([
            'name' => 'Name my post №85',
            'description' => 'It is my first description for my local post64',
        ]);
        $post_get4 = $repository->findAll();
//        example of return:
//        return new Response(
//            'well done? it is ok' .$post_get->getName() .'<br/>'.
//            'post_get2: '. $post_get2->getId() .'<br/>'.
//            'post_get3:' . $post_get3->getId() .'<br/>'
//        );
        $repository = $doctrine->getRepository(Author::class);
        $author_get = $repository->find(1);
        return $this->render('post/showPost.html.twig', [
            'posts' => $post_get4,
            'post' => $post_get,
            'author' => $author_get,
        ]);
    }
}

//1.33.28

