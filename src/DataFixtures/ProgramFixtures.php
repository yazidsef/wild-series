<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i=0 ; $i<40 ; $i++){
            $program = new Program();
            $program->setTitle($faker->lastName());
            $program->setSynopsis($faker->text);
            $program->setPoster($faker->name);
            $program->setCategory($this->getReference('category_'.rand(0,9)));
            $program->setCountry($faker->country);
            $program->setOwner($this->getReference('admin'));
            $program->setSlug($this->slugger->slug($program->getTitle()));
            $program->setSlug($this->slugger->slug($program->getTitle()));
            $this->addReference('program_'.$i, $program);
            $manager->persist($program);
        }
        

        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}
