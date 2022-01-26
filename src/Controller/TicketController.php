<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketType;
use App\Form\TaskType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/ticket", name="app_ticket")
     */
    public function createTicket(Request $request)
    {
        $ticket = new Ticket();
        // ...

        $form = $this->createForm(TaskType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticket = $form->getData();
            $this->em->persist($ticket);
            $this->em->flush();
            $this->addFlash(
                'notice',
                'Your ticket added successfully!'
            );

            return $this->redirectToRoute('myticket');
        }

        return $this->renderForm('/ticket/ticketindex.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * @Route("/ticket/ticketsTab", name="myticket")
     */
    public function ticketsTab(TicketRepository $ticketRepository): Response
    {
        return $this->render('myticket/mytickets.html.twig', [
            'tickets' => $ticketRepository->findAll()
        ]);
    }

    /**
     * @Route("/ticket/{id}", name="ticket_show")
     */
    public function showticket(int $id, TicketRepository $ticketRepository)
    {
        $ticket = $ticketRepository->find($id);
        return $this->render('myticket/show.html.twig', [
            "ticket" => $ticket,
        ]);
    }
    /**
     * @Route("/ticket/update/{id}", name="update")
     */
    public function updateTicket(Request $request, Ticket $ticket)
    {
        $form = $this->createForm(TaskType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($ticket);
            $this->em->flush();

            return $this->redirectToRoute('myticket');
        }

        return $this->renderForm('/myticket/update.html.twig', [
            'form' => $form,

        ]);
    }
    /**
     * @Route("/ticket/delete/{id}", name="delete")
     */
    public function deleteTicket(Ticket $ticket)
    {
        $this->em->remove($ticket);
        $this->em->flush();

        return $this->redirectToRoute('myticket');
    }
}
