<?php

namespace App\Form\Comment;

use App\Model\DTO\Comment\CreateCommentDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'trick.show.comment.label',
                'attr' => [
                    'placeholder' => 'trick.show.comment.placeholder',
                    'rows' => 1,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCommentDTO::class,
            'translation_domain' => 'form',
        ]);
    }
}
