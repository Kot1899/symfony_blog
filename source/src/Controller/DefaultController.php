<?php

/*Создай в своем проекте несколько правил роутинга, через аннотации. Метод в классе LuckyController, метод с названием number (аналогично расмотренному в уроке).

Также сделай еще один класс DefaultController, с методом index, который выведет Hello world!, и будет доступен по корневой ссылке http://localhost:8000/

Результат закоммитить, предоставить скриншот результата работы с выводом Hello world!
*/
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Entity\Author;
use App\Repository\PostRepository;
use Doctrine\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Vitali Romanenko <vit.romanenko@gmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     * @return response
     * @author Vitali Romanenko
     * description - main method
     */
    public function index()
    {
        $number1 = 10;
        $number2 = 20;
        $userName = 'Alex';
        $numberSum = $number1 + $number2;
        $users = [
            ['id' => 1, 'name' => 'Alex'],
            ['id' => 2, 'name' => 'Mike'],
            ['id' => 3, 'name' => 'Kile']
        ];
        return $this->render(
            'default/index.html.twig',
            [
            'numberSum' => $numberSum,
            'userName' => $userName,
                'users' => $users,
            ]
        );
    }
    /**
     * @Route("/about", name="default_about")
     * @return response
     * @author Vitali Romanenko
     * description - it is ABOUT link
     */
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/author/kile", name="default_kile")
     * @return response
     * @author Vitali Romanenko
     * description - it is link about author Kile
     */
    public function kile()
    {
        return $this->render('default/kile.html.twig');
    }

    /**
     * @Route("/feedback", name="default_feedback")
     * @return response
     * @author Vitali Romanenko
     * description - it is FEEDBACK link
     */
    public function feedback()
    {
        return $this->render('default/feedback.html.twig');
    }

    /**
     * @Route("/create_post", name="default_create")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * description - its method write new POST to DB
     */
    public function Post(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $post = new Post();
        $post->setName('Name my post №'. rand(0,100));;
        $text="This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, 
code, and more are all supported as expected.
          This is some additional paragraph placeholder content. It has been written to fill the available space and show how a longer snippet of text 
          affects the surrounding content. We'll repeat it often to keep the demonstration flowing, so be on the lookout for this exact same string of text.";
        $post->setDescription($text. rand(0,100));;
        $post->setPublicAt(new \DateTime());

        $entityManager->persist($post);
        $entityManager->flush();

        echo '<pre>';
        var_dump($post);
        return new Response('well done? it is ok');

    }

    /**
     * @Route("/get_post", name="default_get_post")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * description - its method #1 fetching POST from DB (something SELECT) - P.S. default use IT method
     */

    public function Get(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        // look for a single Product by id
        $post_get = $repository->find(17);
        //  это просто проверка на наличие такого номера
            if (!$post_get) {
                throw $this->createNotFoundException(
                    'Hi guys, No post found for id'
//                    . $id
                );
            }

        // look for a single Product by name
        $post_get2 = $repository->findOneBy(['name' => 'Name my post №55']);
        // or find by name and description
        $post_get3 = $repository->findOneBy([
            'name' => 'Name my post №85',
            'description'=>'It is my first description for my local post64'
        ]);
        // look for *all* Post objects
        $post_get4 = $repository->findAll();

//        example of return:
//        return new Response(
//            'well done? it is ok' .$post_get->getName() .'<br/>'.
//            'post_get2: '. $post_get2->getId() .'<br/>'.
//            'post_get3:' . $post_get3->getId() .'<br/>'
//        );
        $repository = $doctrine->getRepository(Author::class);
        $author_get = $repository->find(1);
        return $this->render('default/post.html.twig', [
            'post'=>$post_get,
            'author'=>$author_get,
        ]);
    }

    /**
     * @Route("/get2/{id}", name="default_get")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * description - its method #2 fetching POST from DB (something SELECT)
     */
/*
    public function Get2( int $id, PostRepository $postRepository): Response
    {
        $post_get2 = $postRepository->find($id);
        return new Response('well done, it is ok, u post - ' . $post_get2->getName());
    }
*/

    /**
     * @Route("/create_author", name="default_create_author")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
         * description - its method write new AUTHOR to DB
     */
    public function Author(ManagerRegistry $doctrine): Response
    {
        $entityManager_PA = $doctrine->getManager();

        $author = new Author();
        $author->setAuthor('Kile');
        $entityManager_PA->persist($author);
        $entityManager_PA->flush();

        return new Response('new AUTHOR was wrote');
    }

}

