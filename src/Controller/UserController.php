<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/account", name="app_account", methods="GET")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER'); 

        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/account/edit", name="app_account_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER'); 

        $user = $this->getUser();

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/change-password", name="app_change_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $pwencoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class, null, [
            'current_password_is_required' => true,
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword( $pwencoder->encodePassword($user, $form['plainPassword']->getData() ) );

            $em->flush();

            return $this->redirectToRoute('app_account');

        }

        return $this->render('account/change_password.html.twig',[
            'form' => $form->createView()
        ]);
    }
}