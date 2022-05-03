<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profile = new Profile();
        $profile->setUrl("https://www.facebook.com/bennejmanoureddine");
        $profile->setReseauSocial("Facebook");
        $manager->persist($profile);
    
        $profile1 = new Profile();
        $profile1->setUrl("https://www.instagram.com/nour_eddine_ben_nejma/");
        $profile1->setReseauSocial("Instagram");
        $manager->persist($profile1);
    
        $profile2 = new Profile();
        $profile2->setUrl("https://github.com/Lakhdher");
        $profile2->setReseauSocial("Github");
        $manager->persist($profile2);
    
        $profile3 = new Profile();
        $profile3->setUrl("https://github.com/Lakhdher");
        $profile3->setReseauSocial("Linkedin");
        $manager->persist($profile3);
        
        $manager->flush();
    }
}
