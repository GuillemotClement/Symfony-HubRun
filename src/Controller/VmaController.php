<?php

namespace App\Controller;

use DateTime;
use App\Entity\Vma;
use App\Form\VmaType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VmaController extends AbstractController
{
    #[Route('/vma', name: 'app_vma')]
    public function index(): Response
    {
        return $this->render('vma/index.html.twig', [
            'controller_name' => 'VmaController',
        ]);
    }

    #[Route('vma/new', name: 'vma_new')]
    public function addVma(Request $request, EntityManagerInterface $em): Response
    {
        // on recupere l'utilateur
        $user = $this->getUser();

        // on creer une nouvelle VMA
        $vma = new Vma();
        // creation du formulaire pour ajout VMA
        $formVma = $this->createForm(VmaType::class, $vma);
        $formVma->handleRequest($request);

        // si formulaire est soumis et valide
        if($formVma->isSubmitted() && $formVma->isSubmitted()){
            // on lie user a la nouvelle vma
            $vma->setUser($user);
            // on ajoute la date de creation
            $vma->setCreatedAd(new \DateTimeImmutable());
            $em->persist($vma);
            $em->flush();

            // ajout du message flash 
            $this->addFlash('success', 'Nouvelle VMA ajoutee avec success');

            return $this->redirectToRoute('current_user');
        }

        return $this->render('vma/add.html.twig', [
            'form'=>$formVma->createView()
        ]);
    }

  
}
