<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\GeneratorController;

class CartController extends GeneratorController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function cart()
    {
        return $this->rendering('cart/cart.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
