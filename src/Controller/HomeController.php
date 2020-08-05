<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homePage")
     */
    public function index(AdRepository $repo,UserRepository $repoU )
    {


        return $this->render('home/index.html.twig', [
            'ads'=>$repo->findBestAds(3),
            'users'=>$repoU->findBestUser()
        ]);
    }
}
