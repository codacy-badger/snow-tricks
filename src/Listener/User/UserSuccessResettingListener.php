<?php

namespace App\Listener\User;

use App\Mailer\Mailer;
use App\Model\DTO\User\ResetPassUserDTO;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;

class UserSuccessResettingListener implements EventSubscriberInterface
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
        return [
            'user.resetting.success' => 'onResettingSuccess',
        ];
    }

    public function onResettingSuccess(FormEvent $formEvent)
    {
        /** @var ResetPassUserDTO $resetUserDTO */
        $resetUserDTO = $formEvent->getData();

        $resetUserDTO->setConfirmationToken($token = bin2hex(random_bytes(10)));

        $this->mailer->sendResettingPassEmail($resetUserDTO, $token);
    }
}
