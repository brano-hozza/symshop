<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BlogCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title:',
                'label_attr' =>['class' => 'blog_label'],
                'required' => true,
                'attr'=>['class' => 'blog_input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a title',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your title should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('text', TextType::class, [
                'label' => 'Body:',
                'label_attr' =>['class' => 'blog_label'],
                'required' => true,
                'attr'=>['class' => 'blog_input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a body',
                    ]),
                    new Length([
                        'minMessage' => 'Your title should be at least {{ limit }} characters',
                        'maxMessage' => "Your text shouldn't be longer than 4096 chars",
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => ['class' => 'btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
