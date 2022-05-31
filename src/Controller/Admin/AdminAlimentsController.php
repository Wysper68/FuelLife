<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentFormType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/aliments")
 */
class AdminAlimentsController extends AbstractController
{

    /**
     * @Route("", name="admin_aliments_index")
     */
    public function listAllAliments(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();

        return $this->render('admin/aliments/index.html.twig', [
            'aliments' => $aliments,
        ]);
    }

    /**
     * @Route("/create", name="app_aliment_create")
     */
    public function createAliment(Request $request, EntityManagerInterface $em): Response
    {
       // creates a task object and initializes some data for this example
       $aliment = new Aliment();

       $form = $this->createForm(AlimentFormType::class, $aliment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $aliment->setUser($this->getUser());
            $em->persist($aliment);
            $em->flush();

            return $this->redirectToRoute('admin_aliments_index');
        }

        return $this->render('admin/aliments/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}/edit", name="app_aliment_edit" )
     */
    public function editAliment(Aliment $aliment, Request $request, EntityManagerInterface $em): Response
    {
       $form = $this->createForm(AlimentFormType::class, $aliment, [
           //'method' => 'PUT'
       ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash('success', 'Pin édité');

            return $this->redirectToRoute('admin_aliments_index');
        }

        return $this->render('admin/aliments/edit.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}/delete", name="app_aliment_delete")
     */
    public function deleteAliment(Aliment $aliment, EntityManagerInterface $em, Request $request): Response
    {
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $em->remove($aliment);
            $em->flush();
        }

        return $this->redirectToRoute('admin_aliments_index');
    }
}
