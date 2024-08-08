<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProgramDuration;

#[Route('/', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request,ProgramRepository $programRepository , PaginatorInterface $paginator , ProgramDuration $programDuration ): Response
    {
        $test= new Program();
        $program = $programRepository->findAll();
        $program = $paginator->paginate(
            $program,
            $request->query->getInt('page', 1),
            24
        );
        return $this->render('program/index.html.twig', [
            'programs' => $program,
            'programDuration'=>$programDuration->calculate($test)
        ]);
    }

    

    //methode show pour affichier les details d'un programme
    #[Route('/{slug}',name:'show')]
    public function show(Program $program):Response
    {
        return $this->render('program/show.html.twig',[
            'program'=>$program,
        ]);
    }



    //methode showSeason pour afficher les details d'une saison
    #[Route('/{program}/season/{season}',name:'season_show' , requirements: ['season' => '\d+'])]
    public function showSeason( Season $season , string $program ,ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['slug'=>$program]);
        return $this->render('season/show.html.twig',[
            'seasons'=>$season,
            'program'=>$program,
        ]);
    }

    //methode showEpisode pour afficher les details d'un episode
    #[Route('/{program}/season/{season}/episode/{slug}',name:'episode_show')]
    public function showEpisode( string $program ,Episode $episode ,Season $season , ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['slug'=>$program]);
        return $this->render('episode/show.html.twig',[
            'program'=>$program,
            'seasons'=>$season,
            'episode'=>$episode
        ]);
    }


    // ---- methode new pour ajouter un nouveau programme ----

    #[Route('new', name: 'add_new')]
    public function new(Request $request , EntityManagerInterface $manager):Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($program);
            $manager->flush();
            $this->addFlash('success','un nouveau program a été ajouter ');
            return $this->redirectToRoute('program_add_new');
        }
        return $this->render('program/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
