<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('user/index.html.twig', [
            'username' => $user->getUserName(),
            'apikeys' => $user->getApiKeys(),
        ]);
    }

    #[Route('/user/apikey/create', name: 'app_user_apikey_create')]
    public function createApiKey(UserService $userService, ManagerRegistry $doctrine): RedirectResponse
    {
        $userService->createApiKey($doctrine);
        return $this->redirectToRoute('app_user');

    }
}
