<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Commercial;
use App\Entity\Maison;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*Partie Fixtures (fausees donénes dans la BDD)*/
        // $product = new Product();
        // $manager->persist($product);
        /*for ($i=0; $i<10 ; $i++) {  // crée de 2 à 10 des commerciaux : Steven1, Steven2,.... (données bidons)
                      [toutes les données en bas]
        }*/
        // $commercial = newCommercial(); // Créer un nouveau commercial
        // $commmercial->setName('Steven'); // définit le nom du commercial
        // $manager->persist($commercial); // précise au gestionnaire qu'on va vouloir envoyer un objet en base de donnée (le rend persisstant / liste d'attente)
        // $manager->flush(); // envoit les objets persist"s en base de donnée

        /* Partie Faker*/
        $faker = Faker\Factory::create(); // voir la doc : https://fakerphp.github.io/#basic-usage

        for ($i=0; $i<=5 ; $i++) {  // crée 5 commerciaux bidons
          $commercial = new Commercial(); // Créer un nouveau commercial
          $commercial->setName($faker->name());
          $manager->persist($commercial);
        }

        for ($i=0; $i<=10 ; $i++) {  // crée 10 maisons bidons 
          $maison = new Maison(); // Créer un nouveau maison
          $maison->setTitle('Maison de '.$faker->name()); // définit le nom du maisons
          $maison->setDescription($faker->text(255));
          $maison->setSurface($faker->numberBetween(59, 199)); // donner un chiffre issu de la fourchette défini
          $maison->setRooms($faker->numberBetween(5, 10));
          $maison->setBedrooms($faker->numberBetween(1, 4));
          $maison->setPrice($faker->numberBetween(75000, 580000));
          // $maison = setImg1($faker->imageUrl(640, 480, 'house-1', true));
          // $maison = setImg2($faker->imageUrl(640, 480, 'house-2', true));
          $maison->setImg1('maison-1.png');
          $maison->setImg2('maison-2.png');
          $maison->setCommercial($commercial); // obligé de prendre un commercial en objet
          $manager->persist($maison);
        }
        $manager->flush(); // envoit les objets persists en base de donnée
    }
}
