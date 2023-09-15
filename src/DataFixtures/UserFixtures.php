<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugge
    ){}
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('adming@gmail.fr');
        $admin->setLastname("admin");
        $admin->setFirstname("Pomme");
        $admin->setAdresse('13 rue des fruits');
        $admin->setCodePostal('57000');
        $admin->setVille('pommange');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );

        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $faker = Faker\Factory::create('fr_FR');

        for ($usr = 1 ; $usr <= 5; $usr++) { 
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAdresse($faker->streetAddress);
            $user->setCodePostal(str_replace(' ', '', $faker->postcode));
            $user->setVille($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            $manager->persist($user);
        }
        $manager->flush();
    }
}
