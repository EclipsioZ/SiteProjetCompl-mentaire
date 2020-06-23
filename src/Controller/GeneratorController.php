<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Acme\CustomBundle\API;


use App\Controller\UserController;

class GeneratorController extends AbstractController
{
	
    protected function rendering($template, $parameters = array()){

		$user = $this->get('session')->get('user');

		if(empty($user)) {
			$user = null;
			$token = false;
		}
		
		if($user != null){
			$token = API::call('GET', '/token', false, $user->token);

			if(!$token) {
                $token = false;
            }

            if(isset($token->error)) {
                $token = false;
            } else {
				$token = true;
			}
		}

		$defaultParameters = array(
			'user' => $user,
			'admin' => $token
		);

        return $this->render($template, array_merge($defaultParameters, $parameters));
	}

}