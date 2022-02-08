<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        /*for ($i=0; $i<10 ; $i++) {  // crée de 2 à 10 des commerciaux : Steven1, Steven2,.... (données bidons)
                            ↓
        }*/
        $commercial = newCommercial(); // Créer un nouveau commercial
        $commmercial->SetName('Steven'); // définit le nom du commercial
        $manager->persist($commercial); // précise au gestionnaire qu'on va vouloir envoyer un objet en base de donnée (le rend persisstant / liste d'attente)
        $manager->flush(); // envoit les objets persist"s en base de donnée
    }
}
