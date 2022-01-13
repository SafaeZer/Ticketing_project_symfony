<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Repository\TicketTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyticketController extends AbstractController
{
    /**
     * @Route("/myticket", name="myticket")
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('myticket/mytickets.html.twig', [
            'tickets' => $ticketRepository->findAll()
        ]);
    }

    /**
     * @Route("/myticket/{id}", name="ticket_show")
     */
    public function showticket(int $id, TicketRepository $ticketRepository)
    {
        $ticket = $ticketRepository->find($id);
        return $this->render('myticket/show.html.twig', [
            "ticket" => $ticket,
        ]);
    }
}
