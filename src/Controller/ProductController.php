<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function product()
    {
        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }


}
