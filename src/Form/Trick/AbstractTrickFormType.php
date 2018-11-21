<?php

namespace App\Form\Trick;

use App\Model\DTO\Trick\CreateTrickDTO;
use App\Model\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTrickFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'trick.form.label.trickname',
            ])
            ->add('description', TextType::class, [
                'label' => 'trick.form.label.description',
            ])
            ->add('trickGroup', EntityType::class, [
                'class' => TrickGroup::class,
                'choice_label' => 'name',
                'label' => 'trick.form.label.groupname',
            ])
            ->add('photos', FileType::class, [
                'multiple' => true,
                'label' => 'trick.form.label.photofile',
                'attr' => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple',
                ],
            ])
            ->add('videos', TextareaType::class, [
                'label' => 'trick.form.label.videos'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTrickDTO::class,
            'translation_domain' => 'form',
        ]);
    }
}
