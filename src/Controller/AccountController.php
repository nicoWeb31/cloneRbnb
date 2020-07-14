<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername()
    
        
        return $this->render('account/login.html.twig',[
            'hasError' => $error !==  null,
            'username' => $username 
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @return void
     */
    public function logout()
    {
        return $this->render('account/login.html.twig');
    }
}
