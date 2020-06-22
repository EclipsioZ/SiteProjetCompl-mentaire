<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("user/user", name="user")
     */
    public function user()
    {
        return $this->render('user/user.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
         * @Route("/user/login", name="login")
         */
    public function login()
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/signup", name="signup")
     */
    public function signup()
    {
        return $this->render('user/signup.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('user/admin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

}
