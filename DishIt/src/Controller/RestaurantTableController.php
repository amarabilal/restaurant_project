<?php

namespace App\Controller;

use App\Entity\RestaurantTable;
use App\Form\RestaurantTableType;
use App\Repository\RestaurantTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/table')]
class RestaurantTableController extends AbstractController
{
    #[Route('/', name: 'app_restaurant_table_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(RestaurantTableRepository $restaurantTableRepository): Response
    {
        $tables = $restaurantTableRepository->findAll();

        return $this->render('restaurant_table/index.html.twig', [
            'tables' => $tables,
        ]);
    }

    #[Route('/new', name: 'app_restaurant_table_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_GERANT')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $table = new RestaurantTable();
        $form = $this->createForm(RestaurantTableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN') && $table->getRestaurant()->getGerant() !== $this->getUser()) {
                throw $this->createAccessDeniedException('You can only add tables to your own restaurants.');
            }

            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurant_table_index');
        }

        return $this->render('restaurant_table/new.html.twig', [
            'table' => $table,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_restaurant_table_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(RestaurantTable $table): Response
    {
        return $this->render('restaurant_table/show.html.twig', [
            'table' => $table,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_restaurant_table_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_GERANT')]
    public function edit(Request $request, RestaurantTable $table, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $table->getRestaurant()->getGerant() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only edit tables in your own restaurants.');
        }

        $form = $this->createForm(RestaurantTableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_restaurant_table_index');
        }

        return $this->render('restaurant_table/edit.html.twig', [
            'table' => $table,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_restaurant_table_delete', methods: ['POST'])]
    #[IsGranted('ROLE_GERANT')]
    public function delete(Request $request, RestaurantTable $table, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $table->getRestaurant()->getGerant() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only delete tables in your own restaurants.');
        }

        if ($this->isCsrfTokenValid('delete'.$table->getId(), $request->request->get('_token'))) {
            $entityManager->remove($table);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurant_table_index');
    }
}
