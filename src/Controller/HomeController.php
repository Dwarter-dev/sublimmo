<?php

namespace App\Controller;

use App\Repository\MaisonRepository;
use App\Repository\CommercialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(MaisonRepository $maisonRepository, CommercialRepository $commercialRepository): Response
    {
        //$houses = $maisonRepository->findAll(); on va chercher toutes les maisons en BDD avec findAll() (fonction présente dans MaisonRepository)
        //$houses = $maisonRepository->findBy([], ['id' => 'DESC'], 6);// on lui donne le critère grace à findBy → ici on trie le nombre de maisons affichés
        $houses = $maisonRepository->findLastSix(); // même chose qu'en haut mais avec des query
        // $houses = $maisonRepository->findDernierSix(); // en SQL mais bug

        $commercials = $commercialRepository->findAll();

        return $this->render('home/index.html.twig', [
            'maisons' => $houses, // Puis on les envoies à la vue pour les afficher
            'commerciaux' => $commercials
          ]);
    }
}
