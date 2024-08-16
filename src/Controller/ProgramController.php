<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CommentType;
use App\Form\ProgramType;
use App\Form\SearchProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProgramDuration;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request,ProgramRepository $programRepository , PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SearchProgramType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $search = $request->query->get('search', '');
            $program = $programRepository->findLikeName($search);
        }else{
            $program = $programRepository->findAll();
        }
        $program = $paginator->paginate(
            $program,
            $request->query->getInt('page', 1),
            24
        );
        //$test = 'uazd';
        return $this->render('program/index.html.twig', [
            'programs' => $program,
            'form'=> $form,
            //'programDuration'=>$programDuration->calculate($test)
        ]);
    }
    // ---- methode new pour ajouter un nouveau programme ----

    #[Route('program/new', name: 'add_new')]
    public function new(Request $request , EntityManagerInterface $manager , MailerInterface $mailer , SluggerInterface $slugger):Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $program->setSlug($slugger->slug($program->getTitle()));
            $program->setOwner($this->getUser());
            $program->setPoster('yazidsefsaf');
            $manager->persist($program);
            $manager->flush();
            $email = (new Email())
            ->from('yazidsefsaf45@yahoo.com')
            ->to('yazidsefs20@yahoo.com')
            ->subject('un nouveau program a été ajouter')
            ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));
            $mailer->send($email);
            $this->addFlash('success','un nouveau program a été ajouter ');
            return $this->redirectToRoute('program_add_new');
        }
        return $this->render('program/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    //methode edit pour modifier un programme
    #[Route('program/edit/{id}', name:'edit')]
    public function edit(Program $program = null, Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->getUser() !== $program->getOwner()) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can edit the program!');
        }    
        if (!$program) {
            throw $this->createNotFoundException('Le programme demandé n\'existe pas.');
        }

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('success', 'Le programme a été modifié avec succès');
            return $this->redirectToRoute('program_show', ['slug' => $program->getSlug()]);
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
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
    public function showEpisode( string $program ,Episode $episode ,Season $season , ProgramRepository $programRepository ,
     Request $request , EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $comment->setEpisode($episode);

            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirect or return a re
            $this->addFlash('success','Commentaire ajouté avec succès');
            return $this->redirectToRoute('program_episode_show', ['program'=>$program,'season'=>$season->getId(),'slug'=>$episode->getSlug()]);
        }
        $program = $programRepository->findOneBy(['slug'=>$program]);
        return $this->render('episode/show.html.twig',[
            'program'=>$program,
            'seasons'=>$season,
            'episode'=>$episode,
            'form'=>$form->createView(),
        ]);
    }


    
}
