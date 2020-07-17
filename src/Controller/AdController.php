<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {


        //$repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads'=> $ads
        ]);
    }
    





    /**
     * @Route("/ads/new", name="ads_create")
     * securisation des methodes
     * 
     * 
     * IsGranted("ROLE_USER")
     */
    public function create(Request $req, EntityManagerInterface $man){


        $ad = new Ad();
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){


        foreach($ad->getImages() as $image){
            $image->setAd($ad);
            $man->persist($image);
        }
        $user = $this->getUser();
        $ad->setAuthor($user);
        
        $man->persist($ad);
        $man->flush();

        $this->addFlash(
            'success', 
            "l\'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
        );

        return $this->redirectToRoute('ads_show', [
            'slug'=>$ad->getSlug()
        ]);


        }


        return $this->render('ad/create.html.twig', [
            'form'=> $form->createView()
        ]);
    }


    /**
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()", message ="Cette annonce ne vous appartient pas !!")
     * 
     * @return response
     */
    public function edit(Ad $ad, Request $req,EntityManagerInterface $man)
    {

        $form = $this->createForm(AdType::class,$ad);
        $form ->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){


            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $man->persist($image);
            }
            
            
            $man->persist($ad);
            $man->flush();
    
            $this->addFlash(
                'success', 
                "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrée !"
            );
    
            return $this->redirectToRoute('ads_show', [
                'slug'=>$ad->getSlug()
            ]);
    
    
            }


        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad'=>$ad
        ]);
    }



    /**
     * @Route("/ads/{slug}", name="ads_show")
     */
    public function show(AdRepository $repo, $slug)
    {

        //i fetch ad 
        //findByOne... fetch one value
        //findBy... fetch an array of value


        $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'ad'=> $ad
        ]);
    }



    //ou 


    /**
     * @Route("/ads/{slug}", name="ads_show")
     */
    // public function show(Ad $ad)

    //     return $this->render('ad/show.html.twig', [
    //         'ad'=> $ad
    //     ]);
    // }









}
