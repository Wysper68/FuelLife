<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/users")
 */
class AdminUsersController extends AbstractController
{
    /**
     * @Route("", name="app_admin_users")
     */
    public function listAllUsers(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('admin/users_index.html.twig', [
            'users' => $users,
        ]);
    }
}
