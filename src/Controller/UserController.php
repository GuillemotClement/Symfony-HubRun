<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'current_user')]
    public function getUserProfil(): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        // on recupere date de naissance de la BDD
        $birthday = $user->getDateofbirth();
        // Date actuel
        $now = new \DateTimeImmutable();
        //calcul de la difference entre les deux dates 
        $dif = $now->diff($birthday);
        // on vient recuperer le nombre d'annee entre les deux dates
        $age = $dif->y;

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'age' => $age
        ]);
    }
}
