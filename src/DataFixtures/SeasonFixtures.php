<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($count = 1; $count < 20; $count++) {
            $season = new Season();
            $season->setNumber($count);
            $season->setYear(random_int(1960,2021));
            $season->setDescription("Saison" . $count);
            $season->setProgram($this->getReference('program_'. random_int(0, 4)));
            $this->addReference('season_' . $count, $season);

            $manager->persist($season);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}
