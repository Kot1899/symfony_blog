<?php

namespace App\Controller;

use App\Entity\Post;

use App\Entity\PostTranslation;
use App\Event\PostDeletedEvent;
use App\Form\PostForm;
use App\Repository\PostRepository;
use App\Service\PostExporterHtml;
use App\Service\PostExporterCsv;
use App\Service\SmsSender;
use App\Service\PostExporterInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/create", name="post_create")
     *
     * @param Request         $request
     * @param LoggerInterface $logger
     * @param SmsSender       $smsSender
     *
     * @return Response
     */
    public function create(Request $request, LoggerInterface $logger, SmsSender $smsSender)
    {
        $logger->info('Run create post method');

        $post = new Post();
        //$post->setName('New post');

        $post->translate('en')->setName('new post en');
        $post->translate('de')->setName('new post de');
        $post->translate('ru')->setName('new post ru');
        //$post->translate($request->getLocale())->setName('new post ru');
        $post->mergeNewTranslations();
        $post->setUser($this->getUser());
        $post->setPublishedAt(new \DateTime());

        $postForm = $this->createForm(PostForm::class, $post);

        $postForm->handleRequest($request);
        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $logger->info('Form is valid');
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            $logger->info('Post saved');

            //$smsSender = new SmsSender('gsm-provider.com', 3456);
            $smsSender->sendNotificationCreate('123456789');

            return $this->redirectToRoute('post_show', [
                'post' => $post->getId(),
            ]);
        }

        return $this->render('post/create.html.twig', [
            'post' => $post,
            'postForm' => $postForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{post}", name="post_delete")
     *
     * @param Post                   $post
     * @param EntityManagerInterface $em
     * @param MailerInterface        $mailer
     *
     * @return Response
     */
    public function delete(
        Post $post,
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        MailerInterface $mailer,
        SmsSender $smsSender
    )
    {

        $dispatcher->dispatch(new PostDeletedEvent($post), PostDeletedEvent::NAME);

//        $em->remove($post);
//        $em->flush();

        die('DELETE OK');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/edit/{post}", name="post_edit")
     *
     * @param Post                   $post
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param SmsSender              $smsSender
     *
     * @return Response
     */
    public function edit(
        Post $post,
        Request $request,
        EntityManagerInterface $em,
        SmsSender $smsSender
    ) {

        if ($post->getId() !== 1) { ///
            $this->createAccessDeniedException();
        }

        $postForm = $this->createForm(PostForm::class, $post);

        $postForm->handleRequest($request);
        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $record = $postForm->getData();
            $em->persist($record);
            $record->mergeNewTranslations();
            $em->flush();

            //$smsSender = new SmsSender('gsm-provider.com', 3456);
            $smsSender->sendNotificationEdit('123456789');

            return $this->redirectToRoute('post_show', [
                'post' => $post->getId(),
            ]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'postForm' => $postForm->createView(),
        ]);
    }

    /**
     * @Route("/show/{post}", name="post_show")
     *
     * @param Post $post
     *
     * @return Response
     */
    public function getPost(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/download/{post}.csv", name="post_download_csv")
     *
     * @param Post            $post
     * @param PostExporterCsv $exporterHtml
     *
     * @return Response
     */
    public function downloadCvsAction(Post $post, PostExporterCsv $exporterHtml)
    {
        $exporterHtml->setPost($post);
        $content = $exporterHtml->export();

        $filename = $post->getName() . '.' . $exporterHtml->getFileExtension();

        // Return a response with a specific content
        $response = new Response($content);

        // Create the disposition of the file
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        // Set the content disposition
        $response->headers->set('Content-Disposition', $disposition);

        // Dispatch request
        return $response;
    }

    /**
     * @Route("/download/{post}.html", name="post_download_html")
     *
     * @param Post             $post
     * @param PostExporterHtml $exporterHtml
     *
     * @return Response
     */
    public function downloadHtmlAction(Post $post, PostExporterHtml $exporterHtml)
    {
        $exporterHtml->setPost($post);
        $content = $exporterHtml->export();

        $filename = $post->getName() . '.' . $exporterHtml->getFileExtension();

        // Return a response with a specific content
        $response = new Response($content);

        // Create the disposition of the file
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        // Set the content disposition
        $response->headers->set('Content-Disposition', $disposition);

        // Dispatch request
        return $response;
    }

    /**
     * @Route("/download/{post}", name="post_download")
     *
     * @param Post                  $post
     * @param PostExporterInterface $exporter
     *
     * @return Response
     */
    public function downloadAction(Post $post, PostExporterInterface $exporter)
    {
        $exporter->setPost($post);
        $content = $exporter->export();

        return new Response($content);
    }
}
