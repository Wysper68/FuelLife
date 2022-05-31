<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Aliment;
use App\Entity\Recette;
use App\Form\AlimentSearchFormType;
use App\Form\AlimentFormType;
use App\Repository\AlimentRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontController extends AbstractController
{
    /**
     * @Route("", name="app_home")
     */
    public function index(Request $request): Response
    {
        return $this->render('frontend/index.html.twig', [
        ]);
    }

    /**
     * @Route("/aliments", name="aliments_index")
     */
    public function indexAliments(AlimentRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(AlimentSearchFormType::class, $data);
        $form->handleRequest($request);
        $donnees = $repository->findSearch($data);

        $isAjax = $request->isXmlHttpRequest();
        if($isAjax){
            return new JsonResponse([
                'content' => 123
            ]);
        }
        
        return $this->render('frontend/aliments/index.html.twig', [
            'aliments' => $donnees,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/aliments/{id<[0-9]+>}", name="aliments_show", methods={"POST", "GET"})
     */
    public function showAliment(Aliment $aliment): Response
    {
        return $this->render('frontend/aliments/show.html.twig', 
            compact('aliment')
        );
    }

    /**
     * @Route("/recettes", name="recettes_index")
     */
    public function indexRecettes(RecetteRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {

        $donnees = $repository->findAll();
        $recettes = $donnees;
        
        return $this->render('frontend/recettes/index.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    /**
     * @Route("/recettes/{id<[0-9]+>}", name="recettes_show", methods={"POST", "GET"})
     */
    public function showRecette(Recette $recette): Response
    {
        return $this->render('frontend/recettes/show.html.twig', 
            compact('recette')
        );
    }
    
}

