<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Form\ProgressType;
use Doctrine\ORM\Mapping\Id;
use App\Form\ValidTicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("support_space")
 */
class SupportController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/support", name="support")
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT');

        return $this->render('support/supportTable.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }
    /**
     * @Route("/support-progress/{ticket}", name="support_progress", methods={"GET","POST"}, requirements={"ticket"="\d+"})
     */
    public function progress(Request $request, Ticket $ticket): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT');
        $status = $ticket->getStatus();

        $form = $this->createForm(ProgressType::class, $status);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($status);
            $this->em->flush();

            return $this->redirectToRoute('support');
        }

        return $this->render('support/progress.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("valid/{id}", name="valid_ticket")
     */
    public function  valid(Request $request, Ticket $ticket): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT');

        $form = $this->createForm(ValidTicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('support');
        }

        return $this->render('support/valid.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
