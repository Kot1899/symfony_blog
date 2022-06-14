<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Vitali Romanenko <vit.romanenko@gmail.com>
 */
class PostController extends AbstractController
{
    /**
     * @Route("/newpost", name="post_createPost")
     * @return response
     * description - method for creating new posts
     */
    public function createPost()
    {
        $post= new Post();
        $post->setName('new post from lesson#6');
        $post->setPublicAt(new \DateTime());
        $postForm=$this->createFormBuilder($post);

        $postForm->add('name', TextType::class,[
            'attr'=>['class'=>'form-control']
        ]);
        $postForm->add('description', TextareaType::class,[
            'attr'=>['class'=>'form-control']
        ]);
        $postForm->add('public_at', DateType::class,[
            'widget'=>'single_text',
            'label'=>'Public at:'
        ]);
        $postForm->add('submit', SubmitType::class,[
            'attr'=>['class'=>'form-control',
                'bg'=>'red']
        ]);


        return $this->render('post/create.html.twig', [
        'post'=>$post,
        'postForm'=>$postForm->getForm()->createView(),
        ]
        );
    }
}
