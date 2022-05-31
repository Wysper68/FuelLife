<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\RecetteFormType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/recettes")
 */
class AdminRecettesController extends AbstractController
{
    /**
     * @Route("/", name="admin_recettes_index", methods={"GET"})
     */
    public function index(RecetteRepository $recetteRepository): Response
    {
        return $this->render('admin/recettes/index.html.twig', [
            'recettes' => $recetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_recettes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteFormType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $recette->setUser($this->getUser());
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('admin_recettes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recettes/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_recettes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recette $recette): Response
    {
        $form = $this->createForm(RecetteFormType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_recettes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recettes/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_recettes_delete")
     */
    public function delete(Request $request, Recette $recette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_recettes_index', [], Response::HTTP_SEE_OTHER);
    }
}
