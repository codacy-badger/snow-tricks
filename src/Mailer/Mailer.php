<?php

namespace App\Mailer;


use App\Model\Entity\User;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationEmail(User $user, string $emailToken){
        $message = (new \Swift_Message('[SnowTricks] Confirm your email'))
        ->setFrom('contact@snowtricks.fr')
            ->setTo($user->getEmail())
            ->setBody(
                'your token : '. $emailToken
            );

        $this->mailer->send($message);

        return;
    }
}
