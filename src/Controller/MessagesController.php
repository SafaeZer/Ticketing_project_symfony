<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {
        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());

            $this->em->persist($message);
            $this->em->flush();

            $this->addFlash("message", "message sent successfully.");
            return $this->redirectToRoute("messages");
        }

        return $this->render("messages/send.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        return $this->render('messages/received.html.twig');
    }
    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messages $message): Response
    {
        $message->setIsRead(true);

        $this->em->persist($message);
        $this->em->flush();

        return $this->render('messages/read.html.twig', compact("message"));
    }
    /**
     * @Route("/delete/{id}", name="deletemessage")
     */
    public function delete(Messages $message): Response
    {

        $this->em->remove($message);
        $this->em->flush();

        return $this->redirectToRoute("received");
    }
}
