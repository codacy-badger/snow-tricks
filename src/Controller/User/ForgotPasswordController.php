<?php

namespace App\Controller\User;

use App\Form\User\UserForgotPassType;
use App\Mailer\Mailer;
use App\Model\DTO\User\ForgotPassUserDTO;
use App\Model\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @var Mailer
     */
    private $mailer;

    public function __construct(UserRepository $userRepository, Mailer $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/user/forgot-password", name="user_forgot_password")
     */
    public function forgotPassword(Request $request): Response
    {
        $forgotPassUserDTO = new ForgotPassUserDTO();

        $userForgotPassForm = $this->createForm(UserForgotPassType::class, $forgotPassUserDTO);

        $userForgotPassForm->handleRequest($request);

        if ($userForgotPassForm->isSubmitted() && $userForgotPassForm->isValid()) {
            /** @var User $user */
            $user = $this->userRepository->findOneBy(['email' => $forgotPassUserDTO->getEmail()]);

            if ($user) {
                $user->askRenewPassword(bin2hex(random_bytes(10)));

                $this->userRepository->save($user);

                $this->mailer->sendResettingPassEmail($user);

                $this->addFlash('success', 'user.success.resetting');
            }

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/forgot-pass.html.twig', [
            'user_forgot_pass_form' => $userForgotPassForm->createView(),
        ]);
    }
}
