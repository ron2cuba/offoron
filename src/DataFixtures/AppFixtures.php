<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Band;
use App\Entity\User;
use App\Entity\Style;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager )
    {
        $faker = Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Avatar($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Placeholder($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Science($faker));

        $admin = new User();

        $hash = $this->encoder->encodePassword($admin, "passord");

        $admin->setEmail ('admin@mail.com')
              ->setPassword($hash)
              ->setFullName('Admin')
              ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        

        for($u=0; $u<5;$u++){
            $user = new User();
            
            $hash = $this->encoder->encodePassword($user, "password");

            $user->setEmail("user$u@mail.com")
                ->setFullName($faker->name())
                ->setPassword($hash);

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
