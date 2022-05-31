<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/categories")
 */
class AdminCategoriesController extends AbstractController
{

     /**
     * @Route("", name="app_admin_categories")
     */
    public function listAllCategories(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/create", name="app_category_create")
     */
    public function createCategory(Request $request, EntityManagerInterface $em): Response
    {
       // creates a task object and initializes some data for this example
       $cat = new Category();

       $form = $this->createForm(CategoryFormType::class, $cat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/categories/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}/edit", name="app_category_edit")
     */
    public function editCategory(Category $category, Request $request, EntityManagerInterface $em): Response
    {
       $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash('success', 'Pin édité');

            return $this->redirectToRoute('app_admin_categories');
        }

        return $this->render('admin/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<[0-9]+>}/delete", name="app_category_delete")
     */
    public function deleteCategory(Category $category, EntityManagerInterface $em, Request $request): Response
    {
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('app_admin_categories');
    }
}
