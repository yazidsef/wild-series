<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class ProgramFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i=0 ; $i<100 ; $i++){
            $program = new Program();
            $program->setTitle($faker->sentence);
            $program->setSynopsis($faker->text);
            $program->setPoster($faker->name);
            $program->setCategory($this->getReference('category_'.rand(0,9)));
            $program->setCountry($faker->country);
            $manager->persist($program);
        }
        

        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
