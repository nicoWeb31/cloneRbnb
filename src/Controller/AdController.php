<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
     */
    public function create(){


        $ad = new Ad();
        $form = $this->createFormBuilder($ad)
            ->add('title')
            ->add('introduction')
            ->add('content')
            ->add('rooms')
            ->add('price')
            ->add('coverImage')
            ->add('save', SubmitType::class, [
                'label' => 'creer la nouvelle annonce',
                'attr'=> [
                    'class' => 'btn btn-primary'
                ]
            ])

            ->getForm();




    
        return $this->render('ad/create.html.twig', [
            'form'=> $form->createView()
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
