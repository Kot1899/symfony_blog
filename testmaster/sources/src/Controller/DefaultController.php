<?php

namespace App\Controller;

use App\Form\FeedbackForm;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class DefaultController
 * @package App\Controller
 *
 * @author Alex Burmistrov <ab@piogroup.net>
 */
class DefaultController extends AbstractController
{
    /**
     * @return RedirectResponse
     */
    public function defaultLocale()
    {
        // REFERER
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/", name="homepage")
     *
     * @param EntityManagerInterface $em
     * @param PostRepository         $postRepository
     *
     * @return Response
     */
    public function index(
        EntityManagerInterface $em,
        PostRepository $postRepository,
        TranslatorInterface $translator): Response
    {
        $posts = $postRepository->findAll(['published_at' => 'desc']);

        $user = $this->getUser();
        if (is_null($user)) {
            //... не авторизован
        } else {
            // все ок.
        }

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
            'title' => $translator->trans('Homepage!')
        ]);
    }

    /**
     * @Route("/about", name="default_about")
     *
     * @return Response
     */
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/feedback", name="default_feedback")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function feedback(Request $request)
    {
        $form = $this->createForm(FeedbackForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            dump($data);
            die('OK');
        }

        return $this->render('default/feedback.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/create", name="default_create")
     *
     * @return Response
     */
    public function createPost()
    {
        $post = new Post();
        $post->setName('New post - ' . rand(0, 100));
        $post->setDescription('My post description');
        $post->setPublishedAt(new \DateTime());

        $post2 = new Post();
        $post2->setName('New post - ' . rand(0, 100));
        $post2->setDescription('My post description');
        $post2->setPublishedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();

        //$post3 = $em->getRepository(Post::class)->find(13);
        // DBAL

        $em->persist($post);
        $em->persist($post2);

        //$em->remove($post3);
        $em->flush();

        return new Response('OK!');
    }

    /**
     * @Route("/search", name="search")
     *
     * @param Request $request
     * @param Response
     */
    public function search(Request $request):Response
    {
        $list = $this->getDoctrine()
            ->getRepository(Post::class)
            ->search($request->get('keyword'), $request->getLocale());

        return $this->render('default/search.html.twig', [
            'list' => $list,
        ]);
    }
}
