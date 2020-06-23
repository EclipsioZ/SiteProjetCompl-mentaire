<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends GeneratorController
{
    /**
     * @Route("/admin/admin", name="admin")
     */
    public function admin()
    {
        return $this->rendering('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
