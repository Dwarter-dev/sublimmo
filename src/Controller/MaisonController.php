<?php

namespace App\Controller;

use App\Repository\MaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}