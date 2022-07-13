<?php

namespace App\DataFixtures;

use App\DataFixtures\Interfaces\IConfigFixtures;
use App\Entity\Interfaces\IRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements IConfigFixtures,IRole
{
    private  UserPasswordHasherInterface $userPassword;

    public function __construct(UserPasswordHasherInterface $userPasswordInterface)
    {
        $this->userPassword = $userPasswordInterface;
    }

    public function load(ObjectManager $manager): void
    {
	    $faker = Faker\Factory::create('fr_FR');
 
        /**
         * Création d'un utilisateur en rôle ADMIN pour tester le rôle
         */
               $admin = new User();
               $admin->setEmail("pc.lee.simplon@gmail.com");
               $admin->setPassword($this->userPassword->hashPassword($admin, "123456"));
               $admin->addRole(self::ROLE_ADMIN);
               $admin->setNom($faker->lastName());
               $admin->setPrenom($faker->firstName());
               $admin->setDatenaissance($faker->datetime());
               $admin->setService($this->getReference("service1"));
               $admin->setPoste($this->getReference("poste1"));
               $manager->persist($admin);     

        /**
         * Création d'utilisateurs aléatoire
         */
            for ($i=0; $i < self::NBR_USERS; $i++) { 
                
                $user = new User();
                $user->setEmail($faker->email());
                $user->setPassword($this->userPassword->hashPassword($user, $faker->words(1,true)));
                $user->setNom($faker->lastName());
                $user->setPrenom($faker->firstName());
                $user->setDatenaissance($faker->datetime());
                $user->setService($this->getReference("service".rand(1,4)));
                $user->setPoste($this->getReference("poste".rand(1,self::NBR_POSTE)));
                $manager->persist($user);    
            }   

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
           ServiceFixtures::class,
           PosteFixtures::class
        ];
    }
}
