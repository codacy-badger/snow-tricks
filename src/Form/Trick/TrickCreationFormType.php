<?php

namespace App\Form\Trick;

use App\Model\DTO\Trick\CreateTrickDTO;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickCreationFormType extends AbstractTrickFormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTrickDTO::class,
            'translation_domain' => 'form',
        ]);
    }
}
