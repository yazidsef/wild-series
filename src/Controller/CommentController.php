<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/comment', name: 'index')]
    public function index(Request $request , EntityManagerInterface $entityManager): Response
    {
      

        return $this->render('comment/index.html.twig', [
            'form' => '$form->createView()'
                ]);
    }
    #[Route('/delete/{id}', name:'delete')]
    public function delete( Comment $comment,EntityManagerInterface $entityManager): Response
    {
        $episode=$comment->getEpisode();
        $season = $episode ->getSeason();
        $program = $season->getProgram();
        $entityManager->remove($comment);
        $entityManager->flush();
        $this->addFlash('danger','le commentaire a été bien supprimé ');
        
        return $this->redirectToRoute('program_episode_show',[
            'program'=>$program->getSlug(),
            'season'=> $season->getId(),
            'slug'=>$episode->getSlug()
        ]);
    }
}
