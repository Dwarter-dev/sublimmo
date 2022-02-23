<?php

namespace App\Controller;
// Entités
use App\Entity\Maison;
use App\Repository\MaisonRepository;
// Classes
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(SessionInterface $sessionInterface, MaisonRepository $maisonRepository): Response
    {
        $sessionCart = $sessionInterface->get('cart', []);; // récupération du panier
        $cart = []; // initialisation du panier (tableau)
        $total = 0; // initialisation du motant total
        //dd($sessionCart); // affichage express du rsultat de l'ajout dans le panier
        foreach ($sessionCart as $id => $quantity) {
        $house = $maisonRepository->find($id); // on récupère l'id de la maison
        $element = [ // element stockera : le prix et la quantité
          'product' => $house,
          'quantity' => $quantity,
        ];
        $cart[] = $element; // array_push($cart, $element)
        $total += $house->getPrice() * $quantity; // total du prix en fonction de la quantité
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Maison $maison, SessionInterface $sessionInterface): Response
    // $sessionInterface : donnée présente uniquement dans la session de la page
    {
      // récupère le panier
      $cart = $sessionInterface->get('cart', []); // récupère le panier actuel
      $id = $maison->getId(); // récupère l'id de la maison à ajouter au panier
      if (!empty($cart[$id])){ // si la maison est déja présente dans le panier
        $cart[$id]++;
      }
      else{
        $cart[$id] = 1; // ajout au panier
      }
      $sessionInterface->set('cart', $cart); // sauvegarde le panier en session
      return $this->redirectToRoute('cart_index'); // redirection
    }
    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(Maison $maison, SessionInterface $sessionInterface): Response
    {
      $cart = $sessionInterface->get('cart', []); // récupère le panier actuel
      $id = $maison->getId(); // récupère l'id de la maison à ajouter au panier
      if (!empty($cart[$id])) // si la maison est déja présente dans le panier
      {
        if ($cart[$id] > 1) { // si on a au minimum 2 maisons
            $cart[$id]--; // supprimer un élément du panier
        }
        else{
          unset($cart[$id]); // retirer au panier
        }
      }
      $sessionInterface->set('cart', $cart); // sauvegarde le panier en session
      return $this->redirectToRoute('cart_index'); // redirection
    }

    #[Route('/cart/delete/{id}', name: 'cart_delete')]
    public function delete(Maison $maison, SessionInterface $sessionInterface): Response
    {
      $cart = $sessionInterface->get('cart', []);
      $id = $maison->getId();
      if (!empty($cart[$id])) {
          unset($cart[$id]);
      }
      $sessionInterface->set('cart', $cart); // supprime le panier en session
      return $this->redirectToRoute('cart_index'); // redirection
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(SessionInterface $sessionInterface): Response
    {
      // $sessionInterface->clear() // affiche toute la session (y compris la connexion d'un user)
      // $sessionInterface->set('cart', null);
      $sessionInterface->remove('cart'); // supprime le panier en session
      return $this->redirectToRoute('cart_index'); // redirection
    }
}
