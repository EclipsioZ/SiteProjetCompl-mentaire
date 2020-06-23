<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Controller\EventController;
use App\Acme\CustomBundle\API;

class GeneratorController extends AbstractController
{

    protected function rendering($template, $parameters = array()){

		$user = $this->get('session')->get('user');

		if(empty($user)) {
            $user = null;
        }

		$defaultParameters = array(
			'user' => $user
		);

        return $this->render($template, array_merge($defaultParameters, $parameters));
	}

}