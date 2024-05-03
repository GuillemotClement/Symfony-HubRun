<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_show')]
    public function index(UserRepository $userRepo): Response
    {
        $users = $userRepo->findAll();


        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
