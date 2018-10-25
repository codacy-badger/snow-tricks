<?php

namespace App\Form;

use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'user.form.label.trickname'
            ])
            ->add('description', TextType::class, [
                'label' => 'user.form.label.description'
            ])
            ->add('trickGroup', EntityType::class, [
                'class' => TrickGroup::class,
                'choice_label' => 'name',
                'label' => 'trick.form.label.groupname'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTrickDTO::class,
            'translation_domain' => 'form'
        ]);
    }
}
