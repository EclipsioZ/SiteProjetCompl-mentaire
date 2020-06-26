<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Acme\CustomBundle\API;
use App\Acme\CustomBundle\User;

use Symfony\Component\HttpFoundation\Request;

class AdminController extends GeneratorController
{

    public function admin()
    {
        $contacts = API::call('GET', '/contact/getContact');
        $commands = API::call('GET', '/shop/getCommand');

        return $this->rendering('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
            'contacts' => $contacts->contacts,
            'commands' => $commands->commands,
        ]);
    }
}
