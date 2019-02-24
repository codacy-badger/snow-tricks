<?php

namespace App\Tests\Controller\Traits;

use App\Model\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

trait FakeAuthenticationTrait
{
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $manager = $this->client->getContainer()->get('doctrine');

        /** @var User $user */
        $user = $manager->getRepository(User::class)->find(1);

        $user->confirm();

        $token = new PostAuthenticationGuardToken(
            $user,
            'security.user.provider.concrete.app_user_provider',
            $user->getRoles()
        );
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
