<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $program,
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
