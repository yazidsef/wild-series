<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixutures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i=0 ; $i<15;$i++){
           $actor = new Actor();
          
           $actor->setFirstname($faker->firstName());
           $actor->setLastname($faker->firstName());
           $actor->getBirthDate($faker->date());
           $manager->persist($actor);
        }

        

        $manager->flush();
    }
}
