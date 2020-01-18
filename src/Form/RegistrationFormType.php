<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label'=>'Username:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your username should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],
            ])
            ->add('first_name',TextType::class, [
                'label'=>'First name:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('last_name',TextType::class, [
                'label'=>'Last name:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('email',EmailType::class, [
                'label'=>'Email:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a valid email',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label'=>'Password:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'=>'Agree terms:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'agree'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('agreeGDPR', CheckboxType::class, [
                'label'=>'Accepting GDPR:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'agree'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
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
            'data_class' => User::class,
        ]);
    }
}
