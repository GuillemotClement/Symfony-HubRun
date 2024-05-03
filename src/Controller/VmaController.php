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
        $vma = new Vma();
        $formVma = $this->createForm(VmaType::class, $vma);
        $formVma->handleRequest($request);

        if($formVma->isSubmitted() && $formVma->isValid()){
            $vma->setCreatedAt(new \DateTimeImmutable());
            $em->persist($vma);
            $em->flush();

            $this->addFlash('success', 'La nouvelle VMA a bien ete ajouter');
            return $this->redirectToRoute('user_show');
        }

        return $this->render('vma/add.html.twig', [
            'form'=>$formVma->createView()
        ]);
    }

  
}
