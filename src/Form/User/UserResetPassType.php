<?php

namespace App\Form\User;

use App\Model\DTO\User\ResetPassUserDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserResetPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => ['label' => 'user.form.label.password'],
            'second_options' => ['label' => 'user.form.label.passwordConfirmation'],
            'invalid_message' => 'fos_user.password.mismatch',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResetPassUserDTO::class,
            'translation_domain' => 'form',
            'csrf_protection' => true,
        ]);
    }
}
