<?php

namespace App\Controller;

use App\Entity\Maison;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(SessionInterface $sessioninterface): Response
    {
        $sessionCart = $sessioninterface->get('cart', []);
        dd($sessionCart); // affichage express du rsultat de l'ajout dans le panier
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Maison $maison, SessionInterface $sessioninterface): Response
    // $sessioninterface : donnée présente uniquement dans la session de la page
    {
      // récupère le panier
      $cart = $sessioninterface->get('cart', []); // récupère le panier actuel
      $id = $maison->getId(); // récupère l'id de la maison à ajouter au panier
      if (!empty($cart[$id])) // si la maison est déja présente dans le panier
      {
        $cart[$id]++;
      }
      else
      {
        $cart[$id] = 1; // ajout au panier
      }
      $sessioninterface->set('cart', $cart); // sauvegarde en session
      return $this->redirectToRoute('cart_index'); // redirection
    }
}
