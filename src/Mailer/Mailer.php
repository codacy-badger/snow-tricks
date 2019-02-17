<?php

namespace App\Mailer;

use App\Model\DTO\User\CreateUserDTO;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    public function sendConfirmationEmail(CreateUserDTO $createUser, string $emailToken)
    {
        $confirmLink = $this->urlGenerator->generate(
            'user_confirm',
            ['confirmationToken' => $emailToken],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $message = (new \Swift_Message('[SnowTricks] Confirm your email'))
        ->setFrom('contact@snowtricks.fr')
            ->setTo($createUser->getEmail())
            ->setBody(
                'Follow this link to activate your account : '.$confirmLink
            );

        $this->mailer->send($message);

        return;
    }
}
