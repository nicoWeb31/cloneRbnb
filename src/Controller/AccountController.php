<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
        $username = $utils->getLastUsername();
    
        
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

    /**
     * permet d'afficher le formulaire de s'inscrire
     * @Route("/register", name="register")
     * @return Response
     */
    public function register(Request $req, EntityManagerInterface $man, UserPasswordEncoderInterface $encode)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){


            //on encode le password
            $pass = $encode->encodePassword($user, $user->getHash());
            $user->setHash($pass);

            //on persist et on flush le user
            $man->persist($user);
            $man->flush();

            //flash
            $this->addFlash(
                'success',
                "Votre compte a bien été crée !!, Vous pouvez vous connecter !"
            );

            //redirect
            return $this->redirectToRoute('account_login');

        }
    
        return $this->render('account/register.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/profile", name="profile")
     * @return response
     */
    public function profile()
    {
        return $this->render('account/profile.html.twig');
    }

}
