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
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label'=>$this->translator->trans("USERNAME").":",
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
                'label'=>$this->translator->trans("FIRST_NAME").":",
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('last_name',TextType::class, [
                'label'=>$this->translator->trans("LAST_NAME").":",
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('email',EmailType::class, [
                'label'=>$this->translator->trans("EMAIL").":",
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
                'label'=>$this->translator->trans("PASSWORD").":",
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
                'label'=>$this->translator->trans("AGREE_TERMS").":",
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
                'label'=>$this->translator->trans("AGREE_GDPR").":",
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
                'label' =>$this->translator->trans("SUBMIT").":",
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
