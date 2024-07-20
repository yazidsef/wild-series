<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const   CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Comédie',
        'Drame',
        'Fantastique',
        'Horreur',
        'Policier',
        'Science-Fiction',
        'Thriller',
    ];
    public function load(ObjectManager $manager): void
    {
        foreach(self::CATEGORIES as $i=>$name){
            $category = new Category();
            $category->setName($name);
            $this->addReference('category_'.$i, $category);
            $manager->persist($category);
        }
        
        $manager->flush();
    }
}
