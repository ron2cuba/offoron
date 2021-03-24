<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Band;
use App\Entity\User;
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

        $admin = new User();
        $admin->setEmail ('admin@mail.com')
              ->setPassword('password')
              ->setFullName('Admin')
              ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        

        for($u = 0; $u<5;$u++){
            $user = new User();
            $user->setEmail("user$u@mail.com")
                ->setFullName($faker->name())
                ->setPassword("password");

            $manager->persist($user);
        }

        for($s=0; $s<6;$s++){
            $style= new Style();

            $style->setName($faker->chemicalElement)
            // ->setSlug($this->slugger->slug(\strtolower($style->getName())))
            ->setMainPicture($faker->avatar)
            ->setDescription($faker->text());

            $manager->persist($style);

            for ($b=0; $b < mt_rand(15,20); $b++) { 
                $band = new Band();

                $band->setName($faker->name())
                ->setSlug($this->slugger->slug(\strtolower($band->getName())))
                ->setStyle($style)
                ->setMainPicture($faker->imageUrl(640, 480, $band->getName(), false))
                ->setDescription($faker->text())
                ->setIsFeatured('0')
                ;


                $manager->persist($band);
            }
        }

        $manager->flush();
    }
}
