<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Acme\CustomBundle\API;
use App\Acme\CustomBundle\User;

use Symfony\Component\HttpFoundation\Request;


class ContactController extends GeneratorController
{
    public function pageContact()
    {
        return $this->rendering('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }


    public function newContact(Request $request)
    {

        $data = API::process($request, [
            'firstname' => true,
            'lastname' => true,
            'mail' => true,
            'message' => true
        ]);


        if(!isset($data['error'])) {
            $response = API::call('POST', '/contact/newContact', $data);
            if(!$response) {
                return $this->rendering('contact/contact.html.twig', [ 'error' => 'Impossible d\'ajouter le produit aux panier', 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            if(isset($response->error)) {
                return $this->rendering('contact/contact.html.twig', [ 'error' => $response->error, 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }
            return $this->redirect($this->generateUrl('index_page'));
        }

        return $this->redirect($this->generateUrl('index_page'));
    }
}
