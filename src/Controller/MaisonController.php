<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Repository\MaisonRepository;
use App\Form\MaisonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MaisonController extends AbstractController
{
    #[Route('/maisons', name: 'maison_index')]
    public function index(MaisonRepository $maisonRepository): Response // Ici, on veux récupérer toutes les maisons
    {
        $maisons = $maisonRepository->findAll();
        return $this->render('maison/index.html.twig', [
            'maisons' => $maisons
        ]);
    }

    #[Route('/admin/maisons', name: 'admin_maison_index')]
    public function adminIndex(MaisonRepository $maisonRepository): Response // Ici, on accède au portail admin (modifier/supprimer une maison)
    {
        $maisons = $maisonRepository->findAll();
        return $this->render('admin/maisons.html.twig', [
            'maisons' => $maisons
        ]);
    }

    #[Route('/admin/maisons/create', name: 'maison_create')]
    public function create(Request $request) // Ici, on créera une nouvelle maison
    // Note : Attention avec Atom sur le dernier Componant doit
    {
        $maison = new Maison();
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        return $this->render('admin/maisonForm.html.twig', [
            'maisonForm' => $form->createView()
        ]);
    }

}
