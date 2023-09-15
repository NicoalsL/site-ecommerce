<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProduitFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($prod = 1; $prod <= 10 ; $prod++) { 
            $produit = new Produit;
            $produit->setNom($faker->text(15));
            $produit->setDescription($faker->text());
            $produit->setSlug($this->slugger->slug($produit->getNom())->lower());
            $produit->setPrix($faker->numberBetween(900, 150000));
            $produit->setStock($faker->numberBetween(0, 10));
            $categorie = $this->getReference('cat-'.rand(2,3));
            $produit->setCategories($categorie);
            $manager->persist($produit);
            $this->addReference('prod-'.$prod, $produit);
        }

        $manager->flush();
    }
}
