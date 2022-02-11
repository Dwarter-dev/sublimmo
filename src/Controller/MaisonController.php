<?php

namespace App\Controller;

use App\Form\MaisonType;
use App\Entity\Maison;
use App\Repository\MaisonRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MaisonController extends AbstractController
{
    #[Route('/maisons', name: 'maison_index')]
    public function index(MaisonRepository $maisonRepository): Response
    {
        $houses = $maisonRepository->findAll();
        return $this->render('maison/index.html.twig', [
            'maisons' => $houses,
        ]);
    }

    #[Route('/admin/maisons', name: 'admin_maison_index')]
    public function adminIndex(MaisonRepository $maisonRepository): Response
    {
        $houses = $maisonRepository->findAll();
        return $this->render('admin/maisons.html.twig', [
            'maisons' => $houses
        ]);
    }

    // Partie Création
    #[Route('/admin/maisons/create', name: 'maison_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $maison = new Maison(); // création d'une nouvelle maison
        $form = $this->createForm(MaisonType::class, $maison); // création d'un formulaire avec en paramètre la nouvelle maison
        $form->handleRequest($request); // gestionnaire de requêtes HTTP

        if ($form->isSubmitted() && $form->isValid()) { // vérifie si le formulaire a été envoyé et est valide

            $infoImg1 = $form['img1']->getData(); // récupère les informations de l'image 1
            $extensionImg1 = $infoImg1->guessExtension(); // récupère l'extension de l'image 1
            $nomImg1 = time() . '-1.' . $extensionImg1; // crée un nom unique pour l'image 1
            $infoImg1->move($this->getParameter('dossier_photos_maisons'), $nomImg1); // télécharge l'image dans le dossier adéquat
            $maison->setImg1($nomImg1); // définit le nom de l'iamge à mettre en bdd

            $infoImg2 = $form['img2']->getData();
            if ($infoImg2 !== null) { // Img2 peux être null, donc on lui donne une petite condition
                $extensionImg2 = $infoImg2->guessExtension();
                $nomImg2 = time() . '-2.' . $extensionImg2;
                $infoImg2->move($this->getParameter('dossier_photos_maisons'), $nomImg2);
                $maison->setImg2($nomImg2);
            } else {
                $maison->setImg2(null);
            }

            $manager = $managerRegistry->getManager();
            $manager->persist($maison);
            $manager->flush();

            // message de succès en tant que message flash
            $this->addFlash('success', 'La maison a bien été créer');
            return $this->redirectToRoute('admin_maison_index'); // puis la redirection
        }

        return $this->render('admin/maisonForm.html.twig', [
            'maisonForm' => $form->createView()
        ]);
    }

    #[Route('/admin/maisons/update/{id}', name: 'maison_update')]
    public function update(MaisonRepository $maisonRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
      $maison = $maisonRepository->find($id); // Récupérer l'id et du coup la maison
      $form = $this->createForm(MaisonType::class, $maison); // Générer le formulaire en récupérant les données de la maison avec $maison
      $form->handleRequest($request); // gestionnaire de requêtes HTTP

      // Traitement si le formulaire est envoyé - Attention, avec le mapped, l'image ne se récupère pas
      if ($form->isSubmitted() && $form->isValid()) {

        // Img1
        // Si img1 dans form => supprime l'ancienne img1 =>génère le nom de l'img1 => upload de la nouvelle => setImg1
        $infoImg1 = $form['img1']->getData(); // récupère les informations de l'image 1
        $nomOldImg1 = $maison->getImg1();

        if ($infoImg1 !== null) { // si il y a une image dans le formulaire
          $cheminOldImg1 = $this->getParameter('dossier_photos_maisons') . '/' . $nomOldImg1; // On recompose le chemin de l'ancienne img1 en stockant l'ancien chemin dans une valeur différente
          if (file_exists($cheminOldImg1)) { //vérifie si le fichier existe
             unlink($cheminOldImg1); // Supprimer l'ancienne img1
          }
          // Génère le nom de la nouvelle img1
          $extensionImg1 = $infoImg1->guessExtension(); // (Même que partie create)
          $nomImg1 = time() . '-1.' . $extensionImg1;
          $infoImg1->move($this->getParameter('dossier_photos_maisons'), $nomImg1);// upload de la nouvelle img1
          $maison->setImg1($nomImg1); // setING1
        } else {
          $maison->setImg1($nomOldImg1); // sinon, on remet l'ancienne image avec l'ancien chemin
        }

        // Img2
        // Si img2 dans form => supprime l'ancienne img2 (si elle existe) =>génère le nom de l'img2 => upload de la nouvelle => setImg2
        $infoImg2 = $form['img2']->getData();
        $nomOldImg2 = $maison->getImg2();

        if ($infoImg2 !== null) {
          if ($nomOldImg2 !== null) { // On rajoute la condition de la présence obligatoire de Img2
            $cheminOldImg2 = $this->getParameter('dossier_photos_maisons') . '/' . $nomOldImg2;
            if (file_exists($cheminOldImg2)) {
               unlink($cheminOldImg2);
            }
          }
          $extensionImg2 = $infoImg2->guessExtension();
          $nomImg2 = time() . '-2.' . $extensionImg2;
          $infoImg2->move($this->getParameter('dossier_photos_maisons'), $nomImg2);
          $maison->setImg2($nomImg2);
        }
        else {
          $maison->setImg2($nomOldImg2); // sinon, on remet l'ancienne image avec l'ancien chemin
        }
        // Affichage de la form
        $manager = $managerRegistry->getManager();
        $manager->persist($maison);
        $manager->flush();
        $this->addFlash('success', 'La maison a bien été modifier');
        return $this->redirectToRoute('admin_maison_index');
      }

      return $this->render('admin/maisonForm.html.twig', [
        'maisonForm' => $form->createView()
      ]);
    }

    // Partie Suppression
    #[Route('/admin/maisons/delete/{id}', name: 'maison_delete')]
    public function delete(MaisonRepository $maisonRepository, int $id, ManagerRegistry $managerRegistry)
    {
      // Récupérer la maison à partir de l'id
      $maison = $maisonRepository->find($id); // récupère la maison graçe à son id
      $nomImg1 = $maison->getImg1(); // récupère le nom de l'image1
      //dd($maison); // dd(...) → variant fonctionnel de var_dump qui charge à l'infini sur Symfony

      // Supprimer les images en vérifiant qu'il y a bien un nom d'image
      if ($nomImg1 !==null) { // vérifie qu'il y a bien un nom d'image (et donc une image à supprimer)
          $cheminImg1 = $this->getParameter('dossier_photos_maisons') . '/' . $nomImg1; //reconstitue le chemin de l'image
          if (file_exists($cheminImg1)) { //vérifie si le fichier existe
             unlink($cheminImg1); // supprime le fichier
          }
      }

      $nomImg2 = $maison->getImg2();
      if ($nomImg2 !==null) {
          $cheminImg2 = $this->getParameter('dossier_photos_maisons') . '/' . $nomImg2;
          if (file_exists($cheminImg2)) {
             unlink($cheminImg1);
          }
      }
      // Envoie des valeurs
      $manager = $managerRegistry->getManager();
      $manager->remove($maison);
      $manager->flush();
      // Message de succès
      $this->addFlash('success', 'La maison a bien été supprimé');
      // Redirection
      return $this->redirectToRoute('admin_maison_index');
    }
}
