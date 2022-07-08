<?php

namespace  App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class UserRegistration
{
    /**
     * @Route("/user/register", name="user_testing")
     * @return void
     * @author Vitali Romanenko
     */
    public function testing()
    {
        echo 'hello from userRegistration';
        die;
    }
}
