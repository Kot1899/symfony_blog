<?php

/*Создай в своем проекте несколько правил роутинга, через аннотации. Метод в классе LuckyController, метод с названием number (аналогично расмотренному в уроке).

Также сделай еще один класс DefaultController, с методом index, который выведет Hello world!, и будет доступен по корневой ссылке http://localhost:8000/

Результат закоммитить, предоставить скриншот результата работы с выводом Hello world!
*/
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Vitali Romanenko <vit.romanenko@gmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     * @return response
     * @author Vitali Romanenko
     */
    public function index()
    {
        $number1 = 10;
        $number2 = 20;
        $userName = 'Alex';
        $numberSum = $number1 + $number2;
        $users = [
            ['id' => 1, 'name' => 'Alex'],
            ['id' => 2, 'name' => 'Mike'],
            ['id' => 3, 'name' => 'Kile']
        ];
        return $this->render(
            'default/index.html.twig',
            [
            'numberSum' => $numberSum,
            'userName' => $userName,
                'users' => $users,
            ]
        );
    }
    /**
     * @Route("/about", name="default_about")
     * @return response
     * @author Vitali Romanenko
     */
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/feedback", name="default_feedback")
     * @return response
     * @author Vitali Romanenko
     */
    public function feedback()
    {
        return $this->render('default/feedback.html.twig');
    }
}