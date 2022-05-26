<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class UserController
 * @package App\Controller
 *
 * @author yandex <ab@piogroup.net>
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user/register", name="user_register")
     *
     * @return Response
     */
    public function registerAction()
    {
        return new Response('registerAction');
    }

    /**
     * @Route("/user/forgot", name="user_forgot")
     *
     * @return Response
     */
    public function forgotPasswordAction(UserPasswordHasherInterface $encoder)
    {
        $user = $this->getUser();
        $user->setPassword($encoder->hashPassword('123123'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('forgotPasswordAction');
    }

    /**
     * @Route("/user/profile", name="user_profile")
     *
     * @return Response
     */
    public function profileAction()
    {
        return new Response('profileAction');
    }

    /**
     * @Route("/auth-form", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
