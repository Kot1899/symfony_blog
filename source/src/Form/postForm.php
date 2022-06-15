<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Doctrine\Persistence\ManagerRegistry;
////use App\Controller\ManagerRegistry;
//use App\Repository\PostRepository;
//use Doctrine\DoctrineBundle\Registry;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class postForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('name', TextType::class,[
//            'attr'=>['class'=>'form-control',
                'label'=>'Name label'
        ]);
        $builder->add('description', TextareaType::class,[
            'attr'=>['class'=>'form-control']
        ]);
        $builder->add('public_at', DateType::class,[
            'widget'=>'single_text',
            'label'=>'PubliC at:'
        ]);
        $builder->add('submit', SubmitType::class,[
            'attr'=>['class'=>'form-control',
                'bg'=>'red']
        ]);
    }
}

