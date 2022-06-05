<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HappykotController extends AbstractController
{
    /**
     * @Route("/happykot", name="happy_mouse")
     * @return response
     * @author Vitali Romanenko
     */
    public function mouse()
    {
        return $this->render('happykot/mouse.html.twig');
    }
}
