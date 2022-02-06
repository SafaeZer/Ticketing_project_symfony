<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("collaborator_space")
 */
class CollaboratorController extends AbstractController
{
    /**
     * @Route("/collaborator", name="collaborator")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_COLLABORATOR');

        return $this->render('collaborator/collaborator.html.twig');
    }
}
