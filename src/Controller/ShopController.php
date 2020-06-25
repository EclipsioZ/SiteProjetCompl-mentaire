<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Acme\CustomBundle\API;

use Symfony\Component\HttpFoundation\Request;

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

    public function pageAddProduct()
    {

        $categories = API::call('GET', '/shop/getCategories');
        return $this->rendering('product/addProduct.html.twig', [
            'controller_name' => 'ShopController',
            'categories' => $categories->categories
        ]);
    }

    public function addProduct(Request $request)
    {

        $data = API::process($request, [
            'name' => true,
            'description' => true,
            'category' => true,
            'price' => true,
            'quantity' => true,
            'picture' => true
        ]);

        if(!isset($data['error'])) {
        

            // Get from API
            $response = API::call('POST', '/shop/addProduct', $data);

            if(!$response) {
                return $this->rendering('product/addProduct.html.twig', [ 'error' => 'Impossible d\'ajouter le produit', 'data' => $data ]);
            }

            if(isset($response->error)) {
                return $this->rendering('product/addProduct.html.twig', [ 'error' => $response->error, 'data' => $data ]);
            }

            return $this->redirect($this->generateUrl('shop_page'));

        }

        return $this->redirect($this->generateUrl('shop_page'));

    }


    public function delProduct(Request $request, $id=null)
    {
        if($id == null) {
            return $this->redirect('/shop');
        }

        $data=[];
        $data['id']= $id;

        if(!isset($data['error'])) {

            // Get from API
            $response = API::call('POST', '/shop/delProduct', $data);

            if(!$response) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => 'Impossible de supprimer le produit', 'data' => $data ]);
            }

            if(isset($response->error)) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => $response->error, 'data' => $data ]);
            }

            return $this->redirect($this->generateUrl('shop_page'));

        }
        return $this->redirect($this->generateUrl('shop_page'));
    }

}
