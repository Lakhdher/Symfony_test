<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Yoga",
            "Cuisine",
            "Patisserie",
            "Photographie",
            "Blogging",
            "Lecture",
            "Apprendre une langue",
            "Ameliorer son espaces de vie",
            "Apprendre la programmation",
            "Jeux videos",
            "Chanter",
            "Musique",
            "La guitare",
            "Le violon",
            "Pratiquer du sport",
            "Apprendre a jongler",
            "Créer une chaine Youtube"
        ];
        for ($i=0; $i <count($data) ; $i++) { 
        $hobby = new Hobby();
        $hobby->setDesignation($data[$i]);
        $manager->persist($hobby);
        }
        $manager->flush();
    }
}
