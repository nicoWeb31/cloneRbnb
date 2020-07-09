<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\Routing\Annotation\Route;
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
}
