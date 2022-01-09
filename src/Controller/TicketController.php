<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="app_ticket")
     */
    public function createTicket()
    {
        $ticket = new Ticket();
        // ...

        $form = $this->createForm(TaskType::class, $ticket);

        return $this->renderForm('/ticket/ticketindex.html.twig', [
            'form' => $form,
        ]);
    }
    public function index(): Response
    {
        return $this->render('ticket/ticketindex.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }
}
