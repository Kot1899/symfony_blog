<?php

namespace App\Controller\Admin;

use App\Form\Admin\UserForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
 * @Route("/user")
 */
class UserController extends AbstractController {

    /**
     * @Route("/", name="admin_user_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $list = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new")
     *
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $user = new User;
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $avatarFile */
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $filename = $avatarFile->getClientOriginalName();

                // Move the file to the directory where brochures are stored
                try {
                    $avatarFile->move(
                        $this->getParameter('avatar_directory'),
                        $filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $user->setAvatar($filename);
            }

            $user->setPassword('-'); // set hash

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User saved successfully');
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(User $user)
    {
        dump($user);die;
    }

    /**
     * @Route("/{id}/edit", name="admin_user_edit")
     *
     * @param User                   $user
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(User $user, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $filename = $avatarFile->getClientOriginalName();
                //$filename = time() . sha1($avatarFile->getClientOriginalName()) . '.jpg';

                $avatarFile->move(
                    $this->getParameter('avatar_directory'),
                    $filename
                );

                $user->setAvatar($filename);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'User saved successfully');
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_user_delete")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        //$em->flush();

        return $this->redirectToRoute('admin_user_index');
    }
}
