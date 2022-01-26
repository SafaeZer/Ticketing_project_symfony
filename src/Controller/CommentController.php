<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function createcomment(Request $request)
    {
        // create comment "virgin"
        $comment = new Comment;

        // generate form
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        // Process the form
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new DateTime());
            $comment->setAnnonces($ticket);
            return $this->render('comment/commentindex.html.twig', [
                'commentForm' => $commentForm->createView()
            ]);
        }
    }
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
