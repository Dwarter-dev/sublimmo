<?php

namespace App\Controller;
// Entités
use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Entity\Maison;
use App\Repository\MaisonRepository;
// Classes
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Request;
// Fonctionnement
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    #[Route('/payement', name: 'payement')]
    public function index(Request $request, SessionInterface $sessionInterface, MaisonRepository $maisonRepository): Response
    {
        if($request->headers->get('referer') == 'https://127.0.0.1:8000/panier')
        {
            return $this->redirectToRoute('cart_index');
        }

        $cart = $sessionInterface->get('cart');//  On récupère le contenu du panier
        $stripeCart = []; // initialisation du panier pour Stripe

        foreach ($cart as $id => $quantity) { // pour chaque panier qui a comme id
          	$house = $maisonRepository->find($id);
            $stripeElement = [
              'amount' => $house->getPrice() * 100,
              'quantity' => $quantity,
              'currency' => 'EUR',
              'name' => $house->getTitle()
            ];
            $stripeCart[] = $stripeElement;
        }

        $stripe = new StripeClient('sk_test_51KWKj1Bpbu05Ajz6mRl3ajsjG63qqu2rxSMh11KTE3AdT9ASLtSS6BIfOf25qOQeDG0cZyDoG1kNjZGAxr8TmyFh00r3GLwPUy'); // clé secrète

        // https://stripe.com/docs/payments/accept-a-payment (partie 2 - PHP)
        $stripeSession = $stripe->checkout->sessions->create([ // on crée
        'line_items' => $stripeCart,
        'mode' => 'payment',
        'success_url' => 'https://127.0.0.1:8000/payement/success',
        'cancel_url' => 'https://127.0.0.1:8000/payement/cancel',
        'payment_method_types' => ['card']
        ]);

        return $this->render('payement/index.html.twig', [
            'sessionId' => $stripeSession->id
        ]);
    }

    #[Route('/payement/success', name: 'payement_success')]
    public function success(Request $request, SessionInterface $sessionInterface): Response
    {
      if($request->headers->get('referer') !== 'https://checkout.stripe.com/')
      {
          return $this->redirectToRoute('cart_index');
      }
      // génère une facture
      // envoie un mail de confirmation de commande avec la facture en pièce-joite
      $sessionInterface->remove('cart'); // vider le panier
      return $this->render('payement/success.html.twig');
    }

    #[Route('/payement/cancel', name: 'payement_cancel')]
    public function cancel(Request $request,): Response
    {
      if($request->headers->get('referer') !== 'https://checkout.stripe.com/')
      {
          return $this->redirectToRoute('cart_index');
      }
      return $this->render('payement/cancel.html.twig');
    }
}
