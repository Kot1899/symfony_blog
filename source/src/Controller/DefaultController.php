<?php

/*Создай в своем проекте несколько правил роутинга, через аннотации. Метод в классе LuckyController, метод с названием number (аналогично расмотренному в уроке).

Также сделай еще один класс DefaultController, с методом index, который выведет Hello world!, и будет доступен по корневой ссылке http://localhost:8000/

Результат закоммитить, предоставить скриншот результата работы с выводом Hello world!
*/
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
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
     * @Route("/create", name="default_create")
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
        $post->setDescription('It is my first description for my local post'. rand(0,100));;
        $post->setPublicAt(new \DateTime());

        $entityManager->persist($post);
        $entityManager->flush();

        echo '<pre>';
        var_dump($post);
        return new Response('well done? it is ok');

    }

    /**
     * @Route("/get/{id}", name="default_get")
     * @param ManagerRegistry $doctrine
     * @return response
     * @author Vitali Romanenko
     * description - its method #1 fetching POST from DB (something SELECT) - P.S. default use IT method
     */

    public function Get(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        // look for a single Product by id
        $post_get = $repository->find($id);
        //  это просто проверка на наличие такого номера
            if (!$post_get) {
                throw $this->createNotFoundException(
                    'Hi guys, No post found for id' . $id
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

        return $this->render('default/post.html.twig', [
            'post'=>$post_get,
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
}
