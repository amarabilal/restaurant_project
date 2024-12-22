<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Restaurant;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/menu')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findAll();
        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }

    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_GERANT')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $menu->getRestaurant();
            if (!$this->isGranted('ROLE_ADMIN') && $restaurant->getGerant() !== $this->getUser()) {
                throw $this->createAccessDeniedException('You can only add menus to your own restaurants.');
            }

            $entityManager->persist($menu);
            $entityManager->flush();
            return $this->redirectToRoute('app_menu_index');
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_menu_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_GERANT')]
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $restaurant = $menu->getRestaurant();
        if (!$this->isGranted('ROLE_ADMIN') && $restaurant->getGerant() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only edit menus in your own restaurants.');
        }

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_menu_index');
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
    #[IsGranted('ROLE_GERANT')]
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $restaurant = $menu->getRestaurant();
        if (!$this->isGranted('ROLE_ADMIN') && $restaurant->getGerant() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only edit menus in your own restaurants.');
        }
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_menu_index');
    }
}
