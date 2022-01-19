<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportHomeController extends AbstractController
{
    /**
     * @Route("/support/home", name="support_home")
     */
    public function index(): Response
    {
        return $this->render('support_home/index.html.twig', [
            'controller_name' => 'SupportHomeController',
        ]);
    }
}
