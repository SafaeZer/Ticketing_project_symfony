<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("support_space")
 */
class SupportController extends AbstractController
{
    /**
     * @Route("/support", name="support")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT');

        return $this->render('support/support.html.twig');
    }
}
