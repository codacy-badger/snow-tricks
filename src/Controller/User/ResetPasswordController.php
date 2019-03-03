<?php

namespace App\Controller\User;

use App\Form\User\UserResetPassType;
use App\Model\DTO\User\ResetPassUserDTO;
use App\Model\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
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
     * @Route("/user/reset-password/{confirmationToken}", name="user_reset_password")
     */
    public function resetPassword(Request $request, string $confirmationToken): Response
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['confirmationToken'=> $confirmationToken]);

        if($user != null)
        {
            $resetPassUserDTO = new ResetPassUserDTO();

            $form = $this->createForm(UserResetPassType::class, $resetPassUserDTO);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                {
                    $resetPassUserDTO->setUser($user);

                    $event = new FormEvent($form, $resetPassUserDTO);

                    $this->eventDispatcher->dispatch('user.changePass.success', $event);

                    $user = User::resetPass($resetPassUserDTO);

                    $this->userRepository->save($user);

                    $this->addFlash('success', 'user.success.creation');

                    return $this->redirectToRoute('trick_list');
                }
            }
            return $this->render('user/reset-pass.html.twig', [
                'user_reset_pass_form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('trick_list');
    }
}
