<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Post;
use App\Form\postForm;

use App\Repository\PostRepository;
use App\Service\PostExporterCsv;
use App\Service\PostExporterHtml;
use App\Service\PostExporterInterface;
use Doctrine\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
     * @return redirectToRoute перенаправляе страницу на просмотр после создания
     * description - method for creating new posts
     */
    public function createPost(ManagerRegistry $doctrine, Request $request ): Response
    {
        $mypost = new Post();
        $mypost->setName('new post from lesson#'. rand(0,50));
        $mypost->setPublicAt(new \DateTime());

        $postFormNew=$this->createForm(postForm::class, $mypost);
        $postFormNew->handleRequest($request);
        if( $postFormNew->isSubmitted() && $postFormNew->isValid())
            {
                $entityManager_PA = $doctrine->getManager();
                $entityManager_PA->persist($mypost);
                $entityManager_PA->flush();

                return $this->redirectToRoute('post_showPost',[
                    'postId'=>$mypost->getId(),
                ]);
            }

        return $this->render('post/create.html.twig', [
                'post' => $mypost,
                'postFormNew' => $postFormNew->createView(),
            ]
        );
    }

    /**
     * @Route("/editPost/{postId}", name="post_editMyPost")
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return response
     * @return redirectToRoute перенаправляе страницу на просмотр после редактирования
     * description - method for edit new posts
     */
    public function editMyPost(ManagerRegistry $doctrine, Post $postId, Request $request): Response
    {
        $postFormNew=$this->createForm(postForm::class, $postId);
        $postFormNew->handleRequest($request);
        if( $postFormNew->isSubmitted() && $postFormNew->isValid())
        {
            $entityManager_PA = $doctrine->getManager();
            $entityManager_PA->persist($postId);
            $entityManager_PA->flush();

            return $this->redirectToRoute('post_showPost',[
                'postId'=>$postId->getId(),
            ]);
        }

        return $this->render('post/edit.html.twig', [
                'postId' => $postId,
                'postFormNew' => $postFormNew->createView(),
            ]
        );
    }

    /**
     * @Route("/showpostId/{postId}", name="post_showPostId")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * ЧЕРЕЗ ID КАК ПАРАМЕТЕР РОУТА (вариант рабочий но приметивный, old school)
     * description - its method #1 fetching POST from DB (something SELECT) - P.S. default use IT method
     */
/*
    public function showPostId(ManagerRegistry $doctrine, int $postId): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $post_get = $repository->find($postId);
        //  это просто проверка на наличие такого номера
        if (!$post_get) {
            throw $this->createNotFoundException(
                'Hi guys, No post found for id'. $postId
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
*/

    /**
     * @Route("/showpost/{postId}", name="post_showPost")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * ЧЕРЕЗ PARAMCONVERTOR КАК ПАРАМЕТЕР РОУТА (вариант современный)
     * description - its method #1 fetching POST from DB (something SELECT) - P.S. default use IT method
     */
    public function showPost(ManagerRegistry $doctrine, Post $postId): Response
    {
        $repository = $doctrine->getRepository(Author::class);
        $author_get = $repository->find(1);
        return $this->render('post/showPost.html.twig', [
            'postId' => $postId,
            'author' => $author_get,
        ]);
    }

    /**
     * @Route("/download/{postId}.csv" , name = "post_download_csv")
     *
     * @param Post            $post
     * @param PostExporterCsv $exporterCsv
     *
     * @phpstan-return  Response
     */
    public function downloadPostExporterCsv(Post $post,PostExporterCsv $exporterCsv)
    {
        $exporterCsv->setPost($post);
        $content= $exporterCsv->export();

        $filename=$post->getName() . '.' . $exporterCsv->getFileExtention();

        //return a response with a specific content
        $response = new Response($content);

        //create the disposition of the file
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename
        );

        //set disposition content
        $response->headers->set('Content-Disposition', $disposition);

        //dispatch request
        return  $response;
    }

    /**
     * @Route("/download/{postId}.html" , name = "post_download_html")
     *
     * @param Post            $post
     * @param PostExporterHtml $exporterHtml
     *
     * @phpstan-return  Response
     */
    public function downloadPostExporterHtml(Post $post,PostExporterCsv $exporterHtml)
    {
        $exporterHtml->setPost($post);
        $content= $exporterHtml->export();

        $filename=$post->getName() . '.' . $exporterHtml->getFileExtention();

        //return a response with a specific content
        $response = new Response($content);

        //create the disposition of the file
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename
        );

        //set disposition content
        $response->headers->set('Content-Disposition', $disposition);

        //dispatch request
        return  $response;
    }

    /**
     * @Route("/download/{postId}" , name= "download_post")
     * @phpstan-param Post                  $post
     * @phpstan-param PostExporterInterface $exporter
     *
     * @phpstan-return Response
     */
    public function downloadAction(Post $post, PostExporterInterface $exporter)
    {
        $exporter->setPost($post);
        $content= $exporter->export();

        return new Response ($content);
    }

}



