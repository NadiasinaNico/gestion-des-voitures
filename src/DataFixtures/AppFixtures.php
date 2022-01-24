<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $marque_1 = new Marque();
        $marque_1->setLibelle("TOYOTA");
        $manager->persist($marque_1);

        $marque_2 = new Marque();
        $marque_2->setLibelle("HONDA");
        $manager->persist($marque_2);

        $marque_3 = new Marque();
        $marque_3->setLibelle("LAND CRUSER");
        $manager->persist($marque_3);

        $modele_1 = new Modele();
        $modele_1->setLibelle('Rayius')
                 ->setImage("modele_1.jpg")
                 ->setPrixMoyenne(3444)
                 ->setMarque($marque_1);
        $manager->persist($modele_1);

        $modele_2 = new Modele();
        $modele_2->setLibelle('Lazer')
                 ->setImage("modele_2.jpg")
                 ->setPrixMoyenne(1224)
                 ->setMarque($marque_2);
        $manager->persist($modele_2);

        $modele_3 = new Modele();
        $modele_3->setLibelle('For')
                 ->setImage("modele_3.jpg")
                 ->setPrixMoyenne(1224)
                 ->setMarque($marque_2);
        $manager->persist($modele_3);

        $modele_4 = new Modele();
        $modele_4->setLibelle('Fer')
                 ->setImage("modele_4.jpg")
                 ->setPrixMoyenne(1224)
                 ->setMarque($marque_3);
        $manager->persist($modele_4);

        $modele_5 = new Modele();
        $modele_5->setLibelle('Fierte')
                 ->setImage("modele_5.jpg")
                 ->setPrixMoyenne(1224)
                 ->setMarque($marque_1);
        $manager->persist($modele_5);

        $modeles = [$modele_1, $modele_2, $modele_3, $modele_4, $modele_5];

        $faker = \Faker\Factory::create('fr_FR');
        foreach($modeles as $modele){
            $rand = rand(3,5);
            for($i = 1; $i <= $rand ; $i++){
                $voiture = new Voiture();
                $voiture->setImmatriculation($faker->regexify("[A-Z]{2}[0-9]{3,4}[A-Z]{2}"))
                        ->setNombrePortes($faker->randomElement($array = array(3,5)))
                        ->setAnnee($faker->numberBetween($min=1990, $max=2022))
                        ->setModele($modele);
                $manager->persist($voiture);
            }
        }


        
        
        

        $manager->flush();
    }
}
