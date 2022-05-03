<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Data Scientist",
            "Statisticien",
            "Médecin ORL",
            "Echographiste",
            "Mathematicien",
            "Analyste Cyber-Sécurity",
            "Higiéniste dentaire",
            "Directeurs des ressources humaines",
            "Ingénieur Logiciels",
            "Ergothérapeute",
            "Actuaire"
        ];
        for ($i=0; $i <count($data) ; $i++) { 
        $job = new Job();
        $job->setDesignation($data[$i]);
        $manager->persist($job);
   
        }
        $manager->flush();
    }
}
