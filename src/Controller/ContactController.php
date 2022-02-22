<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
  #[Route('/contact', name: 'contact')]
  public function index(Request $request, SluggerInterface $slugger, MailerInterface $mailer): Response
  {
    $form = $this-> createForm(ContactType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()){
      $contact = $form->getData();
      $email = (new TemplatedEmail()) // https://symfony.com/doc/current/mailer.html#twig-html-css
        ->from(new Address($contact['email'], $contact['prenom'] . ' ' . $contact['nom']))
        // on récupère les données de ContactType pour compléter le template
        ->to(new Address('dacostasteven91@gmail.com'))
        ->subject('SUBL\'IMMO - demande de contact -' . $contact['objet'])
        ->htmlTemplate('contact/contact_email.html.twig') // chemin du tmeplate twig
        ->context([ // passe les informations du formulaire
            'prenom' => $contact['prenom'],
            'nom' => $contact['nom'],
            'adressEmail' => $contact['email'],
            'objet' => $contact['objet'],
            'message' => $contact['message'],
        ]);
      if ($contact['fichier'] !== null){ // vérifie si le fichier est présnet dans le formulaire
        // Le but de ces 3 valeurs est d'éviter la perte des caractères spéciaux (ex : espace (= %20) serais pas compter)
        $originalFilename = pathinfo($contact['fichier']->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename); // nécessaire pour inclure le nom de fichier dans l'url
        $newFilename = $safeFilename . ' ' . $contact['fichier']->guessExtension();
        // dd($safeFilename); // Test du nom du fichier
        $email->attachFromPath($contact['fichier']->getPathName(), $newFilename); // attache la pièce-jointe au corps du mail
      }
      $mailer->send($email);
      $this->addFlash('success', 'Votre message a bien été envoyé');
      return $this->redirectToRoute('contact');
    }
    return $this->render('contact/index.html.twig', [
        'contactForm' => $form->createView(),
    ]);
  }
}
