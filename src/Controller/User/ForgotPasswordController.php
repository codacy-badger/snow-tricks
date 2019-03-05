<?php

namespace App\Controller\User;

use App\Form\User\UserForgotPassType;
use App\Model\DTO\User\ResetPassUserDTO;
use App\Model\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/user/forgot-password", name="user_forgot_password")
     */
    public function forgotPassword(Request $request): Response
    {
        $resetPassUserDTO = new ResetPassUserDTO();

        $userForgotPassForm = $this->createForm(UserForgotPassType::class, $resetPassUserDTO);

        $userForgotPassForm->handleRequest($request);

        if ($userForgotPassForm->isSubmitted() && $userForgotPassForm->isValid()) {
            /** @var User $user */
            $user = $this->userRepository->findOneBy(['email' => $resetPassUserDTO->getEmail()]);
            if ($user) {
                $resetPassUserDTO->setUser($user);

                $event = new FormEvent($userForgotPassForm, $resetPassUserDTO);

                $this->eventDispatcher->dispatch('user.resetting.success', $event);
            }

            $this->addFlash('success', 'user.success.resetting');

            $user::resetPass($resetPassUserDTO);

            $this->userRepository->save($user);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/forgot-pass.html.twig', [
            'user_forgot_pass_form' => $userForgotPassForm->createView(),
        ]);
    }
}
