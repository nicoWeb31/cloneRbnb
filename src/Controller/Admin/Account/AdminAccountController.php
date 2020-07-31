<?php

namespace App\Controller\Admin\Account;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {

        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('admin/admin_account/index.html.twig',[
            
            'hasError' => $error !==  null,
            'username' => $username 

        ]);

    }
}
