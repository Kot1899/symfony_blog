<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test_myFunction")
     * @return response
     * @author Vitali Romanenko
     */
    public function myFunction()
    {
        return $this->render('test/myFunction.html.twig');
    }
}
