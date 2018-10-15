<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavigateurController extends AbstractController
{
    /**
     * @Route("/navigateur", name="navigateur")
     */
    public function index()
    {

        return $this->render('navigateur/index.html.twig', [
            'controller_name' => 'NavigateurController',
        ]);
    }
}
