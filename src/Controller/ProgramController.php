<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request,ProgramRepository $programRepository , PaginatorInterface $paginator ): Response
    {
        $program = $programRepository->findAll();
        $program = $paginator->paginate(
            $program,
            $request->query->getInt('page', 1),
            24
        );
        return $this->render('program/index.html.twig', [
            'programs' => $program,
        ]);
    }
    #[Route('/{id}',name:'new' , requirements: ['id' => '\d+'])]
    public function show(int $id , Program $program):Response
    {
        return $this->render('program/list.html.twig',[
            'program'=>$program
        ]);
    }
}
