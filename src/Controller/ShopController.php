<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Acme\CustomBundle\API;

use App\Acme\CustomBundle\User;

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

    public function pageAddProduct($id=null)
    {

        if($id == null) {
            return $this->redirect('/shop');
        }

        $categories = API::call('GET', '/shop/getCategories');
        return $this->rendering('product/addProduct.html.twig', [
            'controller_name' => 'ShopController',
            'categories' => $categories->categories,
            'categorie_default' => $id
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
            $displayCategories = API::call('GET', '/shop/getDisplayShop');
            if(!$response) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => 'Impossible de supprimer le produit', 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            if(isset($response->error)) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => $response->error, 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            return $this->redirect($this->generateUrl('shop_page'));

        }
        return $this->redirect($this->generateUrl('shop_page'));
    }

    public function addCategory(Request $request)
    {
        $data = API::process($request, [
            'label' => true
        ]);

        if(!isset($data['error'])) {

            // Get from API
            $response = API::call('POST', '/shop/addCategory/', $data);
            $displayCategories = API::call('GET', '/shop/getDisplayShop');
            if(!$response) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => 'Impossible d\'ajouter la catégorie', 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            if(isset($response->error)) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => $response->error, 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            return $this->redirect($this->generateUrl('shop_page'));

        }
        return $this->redirect($this->generateUrl('shop_page'));
    }

    public function delCategory(Request $request, $id=null)
    {
        if($id == null) {
            return $this->redirect('/shop');
        }

        $data=[];
        $data['id']= $id;

        if(!isset($data['error'])) {

            // Get from API
            $response = API::call('POST', '/shop/delCategory', $data);
            $displayCategories = API::call('GET', '/shop/getDisplayShop');
            if(!$response) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => 'Impossible de supprimer la categorie', 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            if(isset($response->error)) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => $response->error, 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            return $this->redirect($this->generateUrl('shop_page'));

        }
        return $this->redirect($this->generateUrl('shop_page'));
    }

    public function pageDisplayProduct($id=null)
    {

        if($id == null) {
            return $this->redirect('/shop');
        }

        $data=[];
        $data['id']= $id;

        $product = API::call('POST', '/shop/getProduct', $data);

        return $this->rendering('product/product.html.twig', [
            'controller_name' => 'ShopController',
            'product' => $product->product
        ]);
    }

    public function pageCart($id=null)
    {

        if($id == null) {
            return $this->redirect('/shop');
        }

        $data=[];
        $data['id']= $id;

        $cart = API::call('POST', '/shop/getCart', $data);

        return $this->rendering('cart/cart.html.twig', [
            'controller_name' => 'ShopController',
            'carts' => $cart->cart
        ]);
    }

    public function addCart(Request $request, $id=null)
    {

        if($id == null) {
            return $this->redirect('/shop');
        }

        $session = $request->getSession();
        $user = new User($request);

       if(!$user->isLogged()) {
            die('You are not logged');
        }

        $data = API::process($request, [
            'quantity' => true
        ]);

        $data['id']= $id;
        $data['userID']= $user->getUser()->id;

        if(!isset($data['error'])) {
            $response = API::call('POST', '/shop/addCart', $data);
            $displayCategories = API::call('GET', '/shop/getDisplayShop');
            if(!$response) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => 'Impossible d\'ajouter le produit aux panier', 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            if(isset($response->error)) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => $response->error, 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }
            return $this->redirect($this->generateUrl('shop_page'));
        }

        return $this->redirect($this->generateUrl('shop_page'));
    }
    
    public function commandEvent(Request $request, $id=null, $quantity=null)
    {

        if($id == null) {
            return $this->redirect('/shop');
        }

        if($quantity == null) {
            return $this->redirect('/shop');
        }

        $session = $request->getSession();
        $user = new User($request);

       if(!$user->isLogged()) {
            die('You are not logged');
        }

        $data['id']= $id;
        $data['userID']= $user->getUser()->id;

        $dataq = [];

        for($i = 0; $i < $quantity; $i++) {
            $dataq = API::process($request, ["quantity-$i" => true]) + $dataq;
        }

        $data['quantity'] = $dataq; 

        if(!isset($data['error'])) {
            $response = API::call('POST', '/shop/commandEvent', $data);
            $displayCategories = API::call('GET', '/shop/getDisplayShop');
            if(!$response) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => 'Impossible d\'ajouter le produit aux panier', 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }

            if(isset($response->error)) {
                return $this->rendering('shop/shop.html.twig', [ 'error' => $response->error, 'data' => $data, 'categories' => $displayCategories->displayCategories]);
            }
            return $this->redirect($this->generateUrl('shop_page'));
        }

        return $this->redirect($this->generateUrl('shop_page'));
    }

    public function delProductCart(Request $request, $id=null, $idProduct=null)
    {

        if($id == null) {
            return $this->redirect('/shop');
        }

        if($idProduct == null) {
            
            return $this->redirect('/shop');
        }

        $data['id']= $id;

        $data['idProduct'] = $idProduct; 

        if(!isset($data['error'])) {
            $response = API::call('POST', '/shop/delProductCart', $data);
            $cart = API::call('POST', '/shop/getCart', $data);

            if(!$response) {
                return $this->rendering('cart/cart.html.twig', [ 'error' => 'Impossible d\'ajouter le produit aux panier', 'data' => $data, 'carts' => $cart->cart]);
            }

            if(isset($response->error)) {
                return $this->rendering('cart/cart.html.twig', [ 'error' => $response->error, 'data' => $data, 'carts' => $cart->cart]);
            }

            return $this->rendering('cart/cart.html.twig', [
                'controller_name' => 'ShopController',
                'carts' => $cart->cart
            ]);
        }

        return $this->rendering('cart/cart.html.twig', [
            'controller_name' => 'ShopController',
            'carts' => $cart->cart
        ]);
    }
}