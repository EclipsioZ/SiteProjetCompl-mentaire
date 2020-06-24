<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Acme\CustomBundle\API;

class ShopController extends GeneratorController
{
    public function shop()
    {

        $displayCategories = API::call('GET', '/shop/getDisplayShop');

        return $this->rendering('shop/shop.html.twig', [
            'controller_name' => 'ShopController',
            'categories' => $displayCategories->displayCategories
        ]);
    }

}
