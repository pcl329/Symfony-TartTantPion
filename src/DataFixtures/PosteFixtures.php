<?php

namespace App\DataFixtures;

use App\DataFixtures\Interfaces\IConfigFixtures;
use App\Entity\Poste;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PosteFixtures extends Fixture implements IConfigFixtures
{
    public function load(ObjectManager $manager): void
    {
 
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < self::NBR_POSTE; $i++) { 
            $poste = new Poste();
            $poste->setNom("Intitulé #".$i+1);
            $poste->setDescription($faker->words(70, true));   
            $manager->persist($poste);
           
            $this->addReference("poste".$i+1, $poste);
        }

        $manager->flush();
    }
}
