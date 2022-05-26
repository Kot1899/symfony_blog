<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
class  userController{
    /**
     * @Route("/user/test", name="user_test")
     */
    public function test(){
        echo 'hello kot3';
        die;
    }
}