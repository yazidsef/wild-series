<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodesFixtures extends Fixture implements DependentFixtureInterface
{
    
        private $slugger;
        public function __construct(SluggerInterface $slugger){
            $this->slugger = $slugger;
        }
    public function load(ObjectManager $manager): void
    {
        

        for($i=0 ; $i<40 ; $i++){
            $faker = Factory::create('fr_FR');
            $episode = new Episode();
            $episode->setTitle($faker->sentence);
            $episode->setSlug($this->slugger->slug($episode->getTitle()));
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynonpsis($faker->text);
            $episode->setSeason($this->getReference("season_".rand(0,25)));
            $manager->persist($episode);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
