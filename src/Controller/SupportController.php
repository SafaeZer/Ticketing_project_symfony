<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Ticket;
use App\Form\AssignType;
use App\Form\ProgressType;
use Doctrine\ORM\Mapping\Id;
use App\Form\ValidTicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\User\UserInterface;
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

        return $this->render('support/support.html.twig');
    }
    /**
     * @Route("/support-tab", name="support_tab")
     */
    public function supportTab(TicketRepository $ticketRepository, UserInterface $responsible): Response
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
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        //$status = $ticket->getStatus();
        $status = new Status();
        var_dump($propertyAccessor->getValue($status, 'name'));
        $form = $this->createForm(ProgressType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $status = $form->getData();
            $ticket->setStatus($status);
            dd($status);
            $this->em->flush();

            return $this->redirectToRoute('support_tab');
        }

        return $this->render('support/progress.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("support-assign/{id}", name="support_assign", methods={"GET","POST"})
     */
    public function  assign(Request $request, Ticket $ticket): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT');

        $form = $this->createForm(AssignType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('support_tab');
        }

        return $this->render('support/assign.html.twig', [
            'ticket' => $ticket,
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
