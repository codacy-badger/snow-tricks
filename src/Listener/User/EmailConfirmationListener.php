<?php

namespace App\Listener\User;


use App\Model\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;

class EmailConfirmationListener implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return array(
            'user.registration.success' => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $formEvent)
    {
        /** @var User $user */
        $user = $formEvent->getData();

    }
}
