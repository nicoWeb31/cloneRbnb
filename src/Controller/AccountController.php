<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PassUpdate;
use App\Form\PassUpdateType;
use App\Form\RegistrationType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @IsGranted("ROLE_USER")
     * 
     * @return response
     */
    public function profile(Request $req,EntityManagerInterface $man)
    {
        //recup l'utilisateur
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class,$user);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){


            //save in bdd
            $man->persist($user);
            $man->flush();

            //message flash
            $this->addFlash('success','Modification du compte avec succés ! ');


            //redirection
            return $this->redirectToRoute('account_login');


        }

        return $this->render('account/profile.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/upDatePassword", name="upDatePassword")
     * @IsGranted("ROLE_USER")
     * 
     * @return response
     */
    public function upDatePassword(Request $req,EntityManagerInterface $man,UserPasswordEncoderInterface $encode)
    {
        $passwordUpdate = new PassUpdate();

        //creation formulaire
        $form = $this->createForm(PassUpdateType::class,$passwordUpdate);
        $form->handleRequest($req);

        //recup l'utilisateur
        $user = $this->getUser();


        
        if($form->isSubmitted() && $form->isValid()){
            //verif du old pass 
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getHash())){

                
                // //gerer l'erreur
                // $this->addFlash('danger','Le mot de passe n\' pas valide ! ');
                // //redirection
                // return $this->redirectToRoute('account_login');

                $form->get('oldPassword')->addError(new FormError("le mot de passe que vous avez taper n'est pas votre mot de passe actuel"));




            }else{

                $user->setHash($encode->encodePassword($user,$passwordUpdate->getNewPass()));
                
                //save in bdd
                $man->persist($user);
                $man->flush();

            //message flash
            $this->addFlash('success','Modification du mot de passe avec succés ! ');


            //redirection
            return $this->redirectToRoute('account_login');
        }

    }

        return $this->render('account/upDatePassword.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     * 
     * @Route("/account", name="account")
     * @IsGranted("ROLE_USER")
     * 
     * @return response
     */
    public function account()
    {

        return $this->render('user/index.html.twig',[
            'user' => $this->getUser()
        ]);
    }


    /**
     * Permet d'afficher la liste des resa faite par l'utilisateur
     * 
     * @Route("/account/booking", name="account_booking")
     * @IsGranted("ROLE_USER")
     * 
     * @return response
     */
    public function accountBooking()
    {

        return $this->render('account/accountBooking.html.twig');
    }

}
