<?php

namespace App\Form\Trick;

use App\Model\DTO\Trick\ModifyTrickDTO;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickModificationFormType extends AbstractTrickFormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModifyTrickDTO::class,
            'translation_domain' => 'form',
        ]);
    }
}
