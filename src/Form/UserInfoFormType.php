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
use Symfony\Contracts\Translation\TranslatorInterface;

class UserInfoFormType extends AbstractType
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name',TextType::class, [
                'label'=>$this->translator->trans("FIRST_NAME").':',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('last_name',TextType::class, [
                'label'=>$this->translator->trans("LAST_NAME").':',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('email',EmailType::class, [
                'label'=>$this->translator->trans("EMAIL").':',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('country',CountryType::class, [
                'label'=>$this->translator->trans("COUNTRY").':',
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('city',TextType::class, [
                'label'=>$this->translator->trans("CITY").':',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('street',TextType::class, [
                'label'=>$this->translator->trans("ADDRESS").':',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('postal',TextType::class, [
                'label'=>$this->translator->trans("POSTAL_CODE").':',
                'label_attr' =>['class' => 'label'],
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('phone_number',TelType::class, [
                'label'=>$this->translator->trans("PHONE_NUMBER").':',
                'required' => true,
                'attr'=>['class' => 'input']
            ])
            ->add('submit', SubmitType::class, [
                'label'=>$this->translator->trans("SUBMIT"),
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
