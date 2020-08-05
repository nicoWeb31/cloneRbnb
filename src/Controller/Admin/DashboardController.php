<?php

namespace App\Controller\Admin;

use App\Service\StatsSaervice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function index(StatsSaervice $stat)
    {


        $stats = $stat->getStats();
        $bestAds =  $stat->getWorsOrBestAds('DESC');
        $worsAds = $stat->getWorsOrBestAds('ASC');

        return $this->render('admin/dashboard/index.html.twig', [

            'stats'=> $stats,
            'bestAds'=> $bestAds,
            'worsAds'=> $worsAds
                
            
        ]);
    }
}
