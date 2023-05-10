<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/add/product')]
class AddProductController extends AbstractController
{
    #[Route('/', name: 'app_add_product', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('add_product/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_add_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_add_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('add_product/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_add_product_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('add_product/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_add_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_add_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('add_product/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_add_product_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_add_product', [], Response::HTTP_SEE_OTHER);
    }
}
