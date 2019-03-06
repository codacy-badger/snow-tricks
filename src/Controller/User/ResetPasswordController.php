<?php

namespace App\Controller\User;

use App\Form\User\UserResetPassType;
use App\Model\DTO\User\ResetPassUserDTO;
use App\Model\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/reset-password/{confirmationToken}", name="user_reset_password")
     */
    public function resetPassword(Request $request, string $confirmationToken): Response
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['confirmationToken' => $confirmationToken]);

        if ($user) {
            $resetPassUserDTO = new ResetPassUserDTO($user);

            $form = $this->createForm(UserResetPassType::class, $resetPassUserDTO);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->resetPass($resetPassUserDTO);

                $this->userRepository->save($user);

                $this->addFlash('success', 'user.success.changePass');

                return $this->redirectToRoute('homepage');
            }

            return $this->render('user/reset-pass.html.twig', [
                'user_reset_pass_form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('homepage');
    }
}
