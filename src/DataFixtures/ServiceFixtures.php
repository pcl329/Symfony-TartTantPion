<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ServiceFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $serviceNom = [
            "Département Système Informatique",
            "Commercial",
            "Secrétariat",
            "Comptabilite"
        ];

        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < count($serviceNom); $i++) { 
            $service = new Service();
            $service->setNom($serviceNom[$i]);
            $service->setDescription($faker->words(70, true));   
            $manager->persist($service);
            $this->addReference("service".$i+1, $service);
        }
        $manager->flush();
    }

}
