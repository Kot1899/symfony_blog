<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class PostDeletedSubscriber implements EventSubscriberInterface
{
    protected $mailer;

    protected $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            PostDeletedEvent::NAME => [
                ['sendEmail', 10],
                ['sendSms', 20],
            ]
        ];
    }

    public function sendEmail(PostDeletedEvent $event)
    {
        $post = $event->getPost();
        echo '...sendEmail  #' . $post->getId() . '<br/>';

        /**
         * Email sender
         */
//        $content = $this->twig->render('email/delete.html.twig', [
//            'post' => $post,
//        ]);
//        $message = new Email();
//        $message->from('burm.courses@gmail.com');
//        $message->to('burmistrov.alexander@gmail.com');
//        $message->subject('Hello from Symfony!');
//        $message->text(
//            'Привет мой дорогой друг, тебе из проекта. Пост #'
//            . $post->getId() . ', был удален'
//        );
//        $message->html($content);
//        $this->mailer->send($message);
    }

    public function sendSms(PostDeletedEvent $event)
    {
        echo '...sendSms<br/>';
//        $smsSender->send('123123123');
    }
}
