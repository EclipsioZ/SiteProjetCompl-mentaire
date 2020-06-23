<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends GeneratorController
{



    /**
     * @Route("/", name= "home")
     */
    public function home (){
      return $this->rendering('home/home.html.twig');
    }

    /**
     * @Route("home/legal", name="legal")
     */
    public function legal()
    {
        return $this->rendering('home/legal.html.twig');
    }

    /**
     * @Route("home/saleCondition", name="saleCondition")
     */
    public function saleCondition()
    {
        return $this->rendering('home/saleCondition.html.twig');
    }





}
