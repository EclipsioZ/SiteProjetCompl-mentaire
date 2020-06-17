<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{



    /**
     * @Route("/", name= "home")
     */
    public function home (){
      return $this->render('home/home.html.twig');
    }

    /**
     * @Route("home/legal", name="legal")
     */
    public function legal()
    {
        return $this->render('home/legal.html.twig');
    }

    /**
     * @Route("home/saleCondition", name="saleCondition")
     */
    public function saleCondition()
    {
        return $this->render('home/saleCondition.html.twig');
    }





}
