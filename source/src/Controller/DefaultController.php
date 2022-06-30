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
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * description - main method
     */
    public function index(ManagerRegistry $doctrine): Response
    {
       $users = [
            ['id' => 1, 'name' => 'Alex'],
            ['id' => 2, 'name' => 'Mike'],
            ['id' => 3, 'name' => 'Kile']
        ];
        $repository = $doctrine->getRepository(Post::class);
        $post_get4 = $repository->findAll(['public_at'=>'desc']);
        $repository = $doctrine->getRepository(Author::class);
        $author_get = $repository->find(1);
        return $this->render(
            'default/index.html.twig',
            [
            'users' => $users,
            'posts' => $post_get4,
            'author' => $author_get,
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
