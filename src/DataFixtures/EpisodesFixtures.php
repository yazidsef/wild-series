<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for($i=0 ; $i<40 ; $i++){
            $faker = Factory::create('fr_FR');
            $episode = new Episode();
            $episode->setTitle($faker->sentence);
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynonpsis($faker->text);
            $seasonReference = 'season_' . $faker->numberBetween(1, 10);
            $episode->setSeasonId($this->getReference($seasonReference));
            $manager->persist($episode);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
