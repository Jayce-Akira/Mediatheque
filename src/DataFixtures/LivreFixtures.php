<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;
use App\Entity\Category;

class LivreFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        
    for($j = 1; $j <= 8; $j++){
        $category = new Category();
        $category->setName("n°$j de la categorie");

        $manager->persist($category);


   
        for($i = 1; $i <= 20; $i++){
            $livre = new Livre();
            $livre->setTitle("Titre du Livre n°$i")
                    ->setImage("http://placehold.it/300x350")
                    ->setDescription("<p>Contenu du livre n°$i")
                    ->setReleaseDate(new \DateTime())
                    ->setAuthor("L\'auteur du livre n°$i")
                    ->setCategory($category);

                    $manager->persist($livre);
                    

        }
    }

        $manager->flush();

    }
}

