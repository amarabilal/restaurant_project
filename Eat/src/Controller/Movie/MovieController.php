<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'show_movie')]
    public function movie(Movie $movie): Response
    {
        return $this->render('movie/detail.html.twig', [
            'movie' => $movie
        ]);
    }

    #[Route('/serie', name: 'show_serie')]
    public function series(): Response
    {
        return $this->render('movie/detail_serie.html.twig');
    }
}
