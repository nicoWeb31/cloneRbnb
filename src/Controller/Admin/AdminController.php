<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/ads", name="admin_ads_index")
     */
    public function index(AdRepository $repo)
    {

        return $this->render('admin/Ad/index.html.twig',[
            'ads' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     * 
     * @return response
     */
    public function edit(Ad $ad,Request $req, EntityManagerInterface $man)
    {

        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $man->persist($ad);
            $man->flush();

            $this->addFlash('success',
            
            "L\'annonce <strong>{$ad->getTitle()}</strong> modifier avec succés");

            return $this->redirectToRoute('admin_ads_index');

        }


        return $this->render('admin/Ad/edit.html.twig',[
            'form' => $form->createView(),
            'ad'=>$ad
        ]);
    }

    
}
