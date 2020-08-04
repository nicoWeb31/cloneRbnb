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
     * Requirement pour contraindre les paramatre d'url ou {page<\d+>?1}  ? pour optionnel et 1 pour la valleur par default
     * @Route("/admin/ads/{page}", name="admin_ads_index", requirements={"page":"\d+"})
     */
    public function index(AdRepository $repo,$page = 1)
    {

        $limit = 10;
        $start = $page * $limit - $limit ;
        //1 * 10 - 10 = 0
        
        $adPagin = $repo->findBy([],[],$limit,$start);
        $total = count($repo->findAll());
        $nbrPage = ceil($total / $limit);


        return $this->render('admin/Ad/index.html.twig',[
            'ads' => $adPagin,
            'total' =>$total,
            'nbrPage' => $nbrPage,
            'page'=>$page
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

    /**
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     * 
     * @return response
     */
    public function delete(Ad $ad, EntityManagerInterface $man)
    {

        if(count($ad->getBookings()) > 0){
            $this->addFlash('warning',"Impossible de suppimer cette annonce <strong> {$ad->getTitle()} </strong>, des résevation sont en cour !");
        }else{


            $man->remove($ad);
            $man->flush();
            $this->addFlash(
                'success',
                "L'annonce <strong> {$ad->getTitle()} </strong> à bien été supprimée !"
            );

        }


        return $this->redirectToRoute('admin_ads_index');

    }


}
