<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]
class PersonneController extends AbstractController
{
    #[Route('/',"Personne.List")]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Personne::class);
        $personnes = $repo->findAll();
        return $this->render("personne/index.html.twig",['personnes' => $personnes]);
    }
    
    #[Route('/{id<\d+>}',"Personne.GetById")]
    public function GetById(Personne $personne = Null): Response
    {
        if(!$personne)
        {
            $this->addFlash('error',"La personne n'existe pas");
            return $this->redirectToRoute("Personne.list");
        }
        return $this->render("personne/detail.html.twig",['personne' => $personne]);
    }


    #[Route('/age/{ageMin}/{ageMax}',"Personne.Age")]
    public function allByAge(ManagerRegistry $doctrine , $ageMin , $ageMax): Response
    {
        $repo = $doctrine->getRepository(Personne::class);
        $personnes = $repo->findPersonneByAgeInterval($ageMin,$ageMax);
        return $this->render("personne/index.html.twig",['personnes' => $personnes]);
    }

    #[Route('/all/{page?1}/{nbre?10}',"Personne.List.Paginated")]
    public function indexAll(ManagerRegistry $doctrine , $page , $nbre): Response
    {
        $repo = $doctrine->getRepository(Personne::class);
        $personnes = $repo->findBy([],[],$nbre,($page-1)*$nbre);
        $nbrePersonne = $repo->count([]);
        $nbrePages = ceil($nbrePersonne / $nbre);
        return $this->render("personne/index.html.twig",
            ['personnes' => $personnes,
            "page" => $page,
            "nbrePages" =>$nbrePages,
            "nbre" => $nbre,
            "isPaginated" => true]
        );
    }

    #[Route('/add', name: 'Personne.Add')]
    public function addPersonne(ManagerRegistry $doctrine , Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class , $personne);
        $form->remove("updatedAt");
        $form->remove("createdAt");
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $manager=$doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash("success",$personne->getName()." a été ajouté avec succés !");
            return $this->redirectToRoute("Personne.List.Paginated");

        }else
        {
            return $this->render('personne/Form-Personne.html.twig', [
                'form' => $form->createView()
            ]);
        }


    }

    #[Route("/delete/{id}","Personne.Delete")]
    public function deletePersonne(Personne $personne = null , ManagerRegistry $doctrine) : Response
    {
        if (!$personne) {
            $this->addFlash("error","personne non trouvable");
        }    
        else{
            $manager=$doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash("success","deleted!");
        }
        return $this->redirectToRoute("Personne.List.Paginated");
    }

    #[Route('/edit/{id?0}', name: 'Personne.Edit')]
    public function editPersonne(Personne $personne = null , ManagerRegistry $doctrine , Request $request): Response
    {
        $new = false;
        if (!$personne) {
        $new = true;
        $personne = new Personne();  
        }
        $form = $this->createForm(PersonneType::class , $personne);
        $form->remove("updatedAt");
        $form->remove("createdAt");
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $manager=$doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $message = "mis à jour";
            if($new)
            {
                $message = "créé";
            }
            $this->addFlash("success",$personne->getName()." a été ".$message." ajouté avec succés !");
            return $this->redirectToRoute("Personne.List.Paginated");

        }else
        {
            return $this->render('personne/Form-Personne.html.twig', [
                'form' => $form->createView()
            ]);
        }


    }
}



