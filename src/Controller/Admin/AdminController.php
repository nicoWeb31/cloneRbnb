<?php

namespace App\Controller\Admin;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
