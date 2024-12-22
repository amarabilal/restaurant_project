<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BannedController extends AbstractController
{
    #[Route('/banned', name: 'app_banned')]
    #[IsGranted('ROLE_BANNED')] 
    public function banned(): Response
    {
        if (!$this->isGranted('ROLE_BANNED')) {
            // Redirige vers l'accueil si l'utilisateur n'est pas banni
            return $this->redirectToRoute('app_home');
        }

        return $this->render('banned/index.html.twig', [
            'message' => 'You are banned and cannot access this site.',
        ]);
    }
}
