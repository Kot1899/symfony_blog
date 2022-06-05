<?php


namespace App\Controller;

//use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TemplateController extends AbstractController
{
    /**
     * @Route("/template", name="template_number")
     * @return response
     * @author Vitali Romanenko
     */
    public function number()
    {
        return $this->render('template/number.html.twig');
    }
}
