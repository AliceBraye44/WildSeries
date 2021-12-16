<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(Slugify $slug)
    {
        $this->slug = $slug;
    }

    public const PROGRAMS = [
        ["Title" => "The Hangover" ,  "Summary" => "Raisonnons, s'il rompait l'engagement, comme on lui objectait que je refusais dans les miennes. Mets-toi en sang, partie en argent et menue monnaie, il n'entre pas par la volonté de mon pouce gauche... Voyez-vous les légères traces de rouille de leurs anciens droits, y compris un roux de feu avec l'ennemi." , "Poster" => "https://images.unsplash.com/photo-1607335614785-e1436e859ebf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" , "Category" => 'category_0'],
        ["Title" => "The World's Fastest Indian" ,  "Summary" => "Maris, aimez vos femmes et tous les jeunes gens et des cultures, de suggérer des investissements ou de susciter des émotions fortes à l'aide, au secours ! Jusqu'en ce lieu de travail du propriétaire, s'écria tout à coup leurs oreilles furent frappées par un grand salon où la curiosité la plus excitée par l'éloge injurieux des amis. Difficile de se faire respecter, mieux que jamais le nom de puissance exécutive." , "Poster" => "https://images.unsplash.com/photo-1544022321-e0f0adb3578a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=435&q=80" , "Category" => 'category_1'],
        ["Title" => "Pet Sematary" ,  "Summary" => "Comme toujours, la tête sur le genou, bénissez-moi ! Emportés tous deux par la bise d'hiver, au mois de février, on brûla quelques voitures, dites de la clairvoyance. Contrefaite, laide et dure de son coeur et le jette à la mer." , "Poster" => "https://images.unsplash.com/photo-1638963895533-cd8b8a114a4f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" , "Category" => 'category_2'],
        ["Title" => "Bohemian Rhapsody" ,  "Summary" => "Retourner à l'élément littéraire une place prédominante qu'il n'avait même plus contre elles les passions populaires ; rien de plus faux en réalité. Saisis cette occasion de visiter ce que tout le pays. Gardez-vous d'en courir les risques de fuites qui pourraient les rendre plus solides !" , "Poster" => "https://images.unsplash.com/photo-1638945657603-bf1fe5112970?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" , "Category" =>'category_3'],
        ["Title" => "Airplane Mode" ,  "Summary" => "Attends un peu, bougre de greluchon, que la mère ne l'avait encore une tendresse auprès d'elle était embarrassée. Avant sa conversion, au dénouement, il sentait déjà monter de la foule des élèves ordinaires. Soufflez sur moi pour cette décision, je mis pied à terre." , "Poster" => "https://images.unsplash.com/photo-1638225985946-11f1770e24f3?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80" , "Category" => 'category_3'],
        ["Title" => "Un Chien Andalou" ,  "Summary" => "Perplexe, il se plaignait pathétiquement de l'effort qu'il appuyait d'un coup ? Dormez, si vous eussiez été là, je parlerai sans haine et sans défense, et se sont égarés par la terreur. Opales, diamants, topazes, rubis étaient jetés autour d'elle ; elle s'y engouffre." , "Poster" => "https://images.unsplash.com/photo-1638225986173-843722214d51?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" , "Category" => 'category_4'],
      ];

    public function load(ObjectManager $manager): void
    {
        foreach (SELF::PROGRAMS as $key => $programInfos) {

            $program = new Program();
            $program->setTitle($programInfos["Title"]);
            $program->setSummary($programInfos["Summary"]);
            $program->setPoster($programInfos["Poster"]);
            $program->setCategory($this->getReference($programInfos["Category"]));
            $program->setSlug($this->slug->generate($programInfos["Title"]));

            for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            }

            $this->addReference('program_' . $key, $program);
            $manager->persist($program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }

}
