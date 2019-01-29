<?php

namespace App\Listener\User;


use App\Mailer\Mailer;
use App\Model\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;

class UserSuccessRegistrationListener implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
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

        $emailToken = random_bytes(10);

        $this->mailer->sendConfirmationEmail($user, $emailToken);

    }
}
