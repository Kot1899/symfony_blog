<?php

/*Создай в своем проекте несколько правил роутинга, через аннотации. Метод в классе LuckyController, метод с названием number (аналогично расмотренному в уроке).

Также сделай еще один класс DefaultController, с методом index, который выведет Hello world!, и будет доступен по корневой ссылке http://localhost:8000/

Результат закоммитить, предоставить скриншот результата работы с выводом Hello world!
*/

namespace App\Controller;

//use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class LuckyController
{
    /**
     * @Route("/luckyCon/number", name="lucky_number")
     * @return response
     * @author Vitali Romanenko
     */
    public function number()
    {
        $message = 'hello it is first method "number" for home task without abstract_controller ';
        return new Response($message);
    }
}
