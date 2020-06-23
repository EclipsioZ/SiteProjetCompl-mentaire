<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends GeneratorController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function shop()
    {
        return $this->rendering('shop/shop.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }

}
