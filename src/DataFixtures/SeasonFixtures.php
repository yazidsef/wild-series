<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 40; $i++) {
            $faker = Factory::create('fr_FR');
            $season = new Season();
            $season->setNumber($faker->numberBetween(1, 10));
            $season->setYear($faker->dateTimeThisYear());
            $season->setDescription($faker->text);
            $season->setprogram($this->getReference('program_'.rand(0,9)));
            $this->addReference("season_".$i,$season);
            $manager->persist($season);
        }

        $manager->flush();
    }
    public function getDependencies(){
        return [ProgramFixtures::class];
    }
}
