<?php

namespace App\Listener\User;


use App\Mailer\Mailer;
use App\Model\DTO\User\CreateUserDTO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;

class EmailConfirmationListener implements EventSubscriberInterface
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
        /** @var CreateUserDTO $createUser */
        $createUser = $formEvent->getData();

        $createUser->setConfirmationToken($token = bin2hex(random_bytes(10)));

        $this->mailer->sendConfirmationEmail($createUser, $token);

    }
}
