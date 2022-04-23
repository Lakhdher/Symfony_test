<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig',[
            "name" => "Ennouryy",
            "first_name" => "lemaalem",
            "random" => "test"
        ]
    
    );
    }
    #[Route('/sayHello/{name}', name: 'say.Hello')]
    public function sayHello($name): Response
    {
        return $this->render('first/sayHello.html.twig',[
            "nom" => $name
        ]
    
    );
    }
}
