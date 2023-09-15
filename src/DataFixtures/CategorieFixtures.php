<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorieFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategorie( 'Informatique', null, $manager);
        
        $this->createCategorie( 'Ordinateurs portable',  $parent, $manager);
        $this->createCategorie( 'Ecran', $parent, $manager);
        $this->createCategorie( 'souris', $parent, $manager);
        
        $parent = $this->createCategorie( 'Informatique', null, $manager);
        $this->createCategorie( 'Homme', $parent, $manager);
        $this->createCategorie( 'Femme', $parent, $manager);
        $this->createCategorie( 'Enfant', $parent, $manager);
        $manager->flush();
    }
    public function createCategorie(string $name, Categorie $parent = null,
    ObjectManager $manager)
    {
        $categorie = new Categorie();
        $categorie->setName($name);
        $categorie->setSlug($this->slugger->slug($categorie->getName())->lower());
        $categorie->setParent($parent);
        $manager->persist($categorie);

        return $categorie;
    }

}
