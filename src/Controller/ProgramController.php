<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
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

    //methode show pour affichier les details d'un programme
    #[Route('/{id}',name:'new' , requirements: ['id' => '\d+'])]
    public function show(int $id , Program $program):Response
    {

        return $this->render('program/show.html.twig',[
            'program'=>$program,
        ]);
    }

    //methode showSeason pour afficher les details d'une saison
    #[Route('/{program}/season/{season}',name:'season_show' , requirements: ['id' => '\d+'])]
    public function showSeason( Season $season , Program $program):Response
    {
        return $this->render('season/show.html.twig',[
            'season'=>$season,
            'program'=>$program
        ]);
    }

    //methode showEpisode pour afficher les details d'un episode
    #[Route('//{id}/season/{season}/episode/{episode}',name:'episode_show' , requirements: ['id' => '\d+'])]
    public function showEpisode(int $id , Program $program ,Season $season , Episode $episode):Response
    {
        return $this->render('episode/show.html.twig',[
            'program'=>$program,
            'season'=>$season,
            'episode'=>$episode
        ]);
    }
}
