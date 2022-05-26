<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserNotifierSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        $var = [
            'post.deleted' => [['notifyUser', 10], ['notifyAdmin', 101], ['notifyMother', 99]],
            'post.created' => [['notifyUser', 10]]
        ];

        return $var;
    }

    public function notifyUser()
    {
        echo '..notifyUser';
    }

    public function notifyAdmin()
    {
        echo '..notifyAdmin';
    }

    public function notifyMother()
    {
        echo '..notifyMother';
    }
}
