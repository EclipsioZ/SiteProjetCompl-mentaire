<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends GeneratorController
{
    /**
     * @Route("/product", name="product")
     */
    public function product()
    {
        return $this->rendering('product/product.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }


}
