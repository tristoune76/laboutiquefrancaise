<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdresseController extends AbstractController
{
    /**
     * @Route("/account/adresse", name="account_adresse")
     */
    public function index(): Response
    {
        return $this->render('account_adresse/index.html.twig', [
            'controller_name' => 'AccountAdresseController',
        ]);
    }
}
