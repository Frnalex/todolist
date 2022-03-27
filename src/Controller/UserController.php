<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\UseCase\UserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function listAction(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/users/create', name: 'user_create')]
    public function createAction(Request $request, UserUseCase $userUseCase): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userUseCase->createAction($user);

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->renderForm('user/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function editAction(User $user, Request $request, UserUseCase $userUseCase): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userUseCase->editAction($user);

            $this->addFlash('success', "L'utilisateur a bien été modifié.");

            return $this->redirectToRoute('user_list');
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
