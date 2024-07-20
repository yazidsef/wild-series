<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'controller_name' => 'ProgramController',
        ]);
    }
    #[Route('/{id}',name:'new' , requirements: ['id' => '\d+'])]
    public function show(int $id):Response
    {
        return $this->render('program/list.html.twig',[
            'id'=>$id 
        ]);
    }
}
