<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfoFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                'attr'=>['class' => 'input']
            ])
            ->add('country',CountryType::class, [
                'label'=>'Country:',
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('city',TextType::class, [
                'label'=>'City:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('street',TextType::class, [
                'label'=>'Street:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('postal',TextType::class, [
                'label'=>'Postal:',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('phone_number',TelType::class, [
                'label'=>'Phone number:',
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Submit',
                'attr'=>['class' => 'btn']
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
