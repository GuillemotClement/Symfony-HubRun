<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function __construct(private FormLoginAuthenticator $authenticator)
    {
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, UserAuthenticatorInterface $userAuthenticator): Response
    {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()){
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Inscription realiser avec success');
            
            return $userAuthenticator->authenticateUser($user, $this->authenticator, $request);
        }
        return $this->render('security/register.html.twig', [
            'form' => $userForm->createView()
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils){
        if($this->getUser()){
            return $this->redirectToRoute('home');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('logout', name: 'logout')]
    public function logout()
    {
    }
}



