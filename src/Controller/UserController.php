<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\UseCase\UserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users/create', name: 'user_create')]
    public function createAction(Request $request, UserUseCase $userUseCase): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userUseCase->createAction($user);

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('user/create.html.twig', [
            'form' => $form,
        ]);
    }
}
