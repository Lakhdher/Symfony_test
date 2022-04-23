<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class ToDoController extends AbstractController
{

    #[Route('', name: 'app_to_do')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has("todos")) {
           $todos = array (
               'achat' => 'acheter clé usb',
               'cours' => "Finaliser mon cours",
               'correction' => "Corriger mes examens"
           );
           $session->set("todos",$todos);
           $this->addFlash('info','Liste initialisée');
        }
        return $this->render('to_do/index.html.twig');
    }

    #[Route('/add/{name}/{content}', name: 'todo-add')]
    public function addTODO(Request $request,$name,$content): Response
    {
        $session = $request->getSession();
        if ($session->has("todos")) {
            $todos=$session->get("todos");
            if (isset($todos[$name])){
                $this->addFlash('error','element existant');
            }
            else{
                $todos[$name]=$content;
                $session->set("todos",$todos);
                $this->addFlash('success','element ajouté');
            }
        }
        else{
            $this->addFlash('error','Liste non initialisée');
        }
        return $this->redirectToRoute('app_to_do');
    }

    #[Route('/update/{name}/{content}', name: 'todo-update')]
    public function updateTodo(Request $request,$name,$content): Response
{
    $session = $request->getSession();
    if ($session->has("todos")) {
        $todos=$session->get("todos");
        if (isset($todos[$name])){
            $todos[$name]=$content;
            $session->set("todos",$todos);
            $this->addFlash("success","Update réussie");
        }
        else{
            $this->addFlash('error','element non existant');
        }
    }
    else{
        $this->addFlash('error','Liste non initialisée');
    }
    return $this->redirectToRoute('app_to_do');
}

    #[Route('/delete/{name}', name: 'todo-delete')]
    public function deletEtodo(Request $request,$name): Response
{
    $session = $request->getSession();
    if ($session->has("todos")) {
        $todos=$session->get("todos");
        if (isset($todos[$name])){
            unset($todos[$name]);
            $session->set("todos",$todos);
            $this->addFlash('success','deleted!');
        }
        else{
            $this->addFlash('error','element non existant!');
        }
    }
    else{
        $this->addFlash('error','Liste non initialisée');
    }
    return $this->redirectToRoute('app_to_do');
}

}