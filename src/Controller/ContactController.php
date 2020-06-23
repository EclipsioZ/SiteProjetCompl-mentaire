<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends GeneratorController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->rendering('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
