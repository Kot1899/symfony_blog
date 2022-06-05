<?php

namespace  App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class userRegistration
{
    /**
     * @Route("/user/register", name="user_testing")
     */
    public function testing()
    {
        echo 'hello from userRegistration';
        die;
    }
}
