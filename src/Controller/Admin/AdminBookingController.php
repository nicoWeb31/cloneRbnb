<?php

namespace App\Controller\Admin;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking", name="admin_booking_index")
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin/admin_booking/index.html.twig', [
            'bookings'=>$repo->findAll(),
        ]);
    }
}
