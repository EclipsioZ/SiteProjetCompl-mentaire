<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Acme\CustomBundle\API;
use App\Acme\CustomBundle\User;
use App\Acme\CustomBundle\Error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends GeneratorController
{
      /**
         * @Route("/user/login", name="login")
         */
    public function login(Request $request)
    {
        $session = $request->getSession();
        //$session->remove('user');
        $user = new User($request);

        if($user->isLogged()) {
            return $this->rendering('user/login.html.twig', [ 'error' => 'Vous êtes déjà connecté!' ]);
        }
        // Request data name => is required (will die if empty)
        $data = API::process($request, [
            'mail' => true,
            'password' => true,
        ]);

        // If data sent
        if(!isset($data['error'])) {
            
            // Get from API
            $user = API::call('POST', '/users/login', $data);

            if(!$user) {
                return $this->rendering('user/login.html.twig', [ 'error' => 'Impossible de se connecter pour le moment.', 'data' => $data ]);
            }

            if(isset($user->error)) {
                return $this->rendering('user/login.html.twig', [ 'error' => $user->error, 'data' => $data ]);
            }

            $session->set('user', $user);

            return $this->redirect($this->generateUrl('index_page'));

        }

        return $this->rendering('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/signup", name="signup")
     */
    public function signup(Request $request)
    {

        $session = $request->getSession();
        //_$session->remove('user');
        $user = new User($request);

        $data = API::process($request, [
            'lastname' => true,
            'firstname' => true,
            'mail' => true,
            'password' => true,
        ]);

        if(!isset($data['error'])) {
            
            // Check if valid data
            $cmail = $this->checkMail($data['mail']);
            if($cmail) {
                return $this->rendering('user/signup.html.twig', ['error' => $cmail, 'data' => $data ]);
            };
            $cpass = $this->checkPassword($data['password']);
            if($cpass) {
                return $this->rendering('user/signup.html.twig', ['error' => $cpass, 'data' => $data ]);
            }

            // Connect to the API
            $result = API::call('POST', '/users/register', $data);

            if(!$result) {
                return $this->rendering('user/signup.html.twig', ['error' => 'Impossible de se créer un compte pour le moment.', 'data' => $data ]);
            }

            if(isset($result->error)) {
                return $this->rendering('user/signup.html.twig', ['error' => $result->error, 'data' => $data ]);
            }

            // Login user
            $dataReg = [
                'mail' => $data['mail'],
                'password' => $data['password'],
            ];

            $usr = API::call('POST', '/users/login', $dataReg);

            if(!$usr) {
                return $this->rendering('user/signup.html.twig', [ 'error' => 'Compte créé, mais impossible de s\'y connecter pour le moment.' ]);
            }

            if(isset($usr->error)) {
                return $this->rendering('user/signup.html.twig', [ 'error' => $usr->error ]);
            }

            $session->set('user', $usr);

            return $this->redirect($this->generateUrl('index_page'));

        }

        return $this->rendering('user/signup.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // public function adminPage(Request $request) {

    //     return $this->rendering('admin.html.twig');

    // }

    public function logout(Request $request) {

        $session = $request->getSession();
        $session->remove('user');

        return $this->redirect($this->generateUrl('index_page'));
    
    }

    // public function token(Request $request) {

    //     $session = $request->getSession();

    //     $user = new User($request);

    //     if(!$user->isLogged()) {
    //         die('You are not logged');
    //     }

    //     API::call('GET', '/token', false, $user->getUser()->token);

    //     return new Response(
    //         'Bienvenue dans la page top secrète, ' . $user->getUser()->token
    //     );

    // }

    public function profilePage(Request $request)
    {

        $user = new User($request);
        if(!$user->isLogged()) {
            die('Not authorized');
        }

        return $this->rendering('user/user.html.twig');

    }

    public function checkPassword($pass) {

        if(strlen($pass) < 6) {
            return 'Mot de passe trop court !';
        }
    
        if(!preg_match("#[0-9]+#", $pass)) {
            return 'Le mot de passe doit contenir au moins un chiffre !';
        }
    
        if(!preg_match("#[A-Z]+#", $pass)) {
            return 'Le mot de passe doit contenir au moins une majuscule !';
        }

        return false;

    }

    public function checkMail($mail) {

        if(!filter_var($mail, FILTER_VALIDATE_EMAIL) || !preg_match("#@.*?\..+?$#", $mail)) {
            return 'Mail Invalide: il!';
         }

         return false;

    }

}
