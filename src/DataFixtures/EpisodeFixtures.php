<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\SeasonFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public const EPISODES = [
        ["Title" => "The Hangover" ,
"Number" => 2,
"Synopsis" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." ,
"Season" => 'season_3'],
["Title" => "The Hangover 3" ,
"Number" => 3,
"Synopsis" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." ,
"Season" => 'season_3'],

["Title" => "The Hangover 4" ,
"Number" => 4,
"Synopsis" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." ,
"Season" => 'season_3'],


["Title" => "Les aventures de Toto " ,
"Number" => 1,
"Synopsis" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." ,
"Season" => 'season_1'],
["Title" => "Les aventures de Toto et tutu" ,
"Number" => 2,
"Synopsis" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." ,
"Season" => 'season_1'],

["Title" => "Toto ne doit jamais jamais jamais facher Grumpy " ,
"Number" => 3,
"Synopsis" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." ,
"Season" => 'season_1'],
      ];

    public function load(ObjectManager $manager): void
    {
        foreach (SELF::EPISODES as $key => $episodeInfos) {

            $episode = new Episode();
            $episode->setTitle($episodeInfos["Title"]);
            $episode->setSynopsis($episodeInfos["Synopsis"]);
            $episode->setNumber($episodeInfos["Number"]);
            $episode->setSeason($this->getReference($episodeInfos["Season"]));

            $this->addReference('episode_' . $key, $episode);
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          SeasonFixtures::class,
        ];
    }
}
