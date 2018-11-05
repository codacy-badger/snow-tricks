<?php

namespace App\Form;

use App\Model\DTO\User\CreateUserDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.form.label.email',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'user.form.label.lastname',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'user.form.label.firstname',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'user.form.label.password',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateUserDTO::class,
            'translation_domain' => 'form',
        ]);
    }
}
