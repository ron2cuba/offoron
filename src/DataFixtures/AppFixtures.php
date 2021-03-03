<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Band;
use App\Entity\Style;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager )
    {
        $faker = Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Avatar($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Placeholder($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Science($faker));

        for($s=0; $s<6;$s++){
            $style= new Style();

            $style->setName($faker->chemicalElement)
            ->setSlug($this->slugger->slug(\strtolower($style->getName())))
            ->setMainPicture($faker->avatar)
            ->setDescription($faker->text());

            $manager->persist($style);

            for ($b=0; $b < mt_rand(15,20); $b++) { 
                $band = new Band();

                $band->setName($faker->name())
                ->setSlug($this->slugger->slug(\strtolower($band->getName())))
                ->setStyle($style)
                ->setMainPicture($faker->imageUrl(640, 480, $band->getName(), false))
                ->setDescription($faker->text());

                $manager->persist($band);
            }
        }

        $manager->flush();
    }
}
