<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking", name="admin_booking_index")
     * @return response
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin/admin_booking/index.html.twig', [
            'bookings'=>$repo->findAll(),
        ]);
    }


    /**
     * for editing a booking
     * @Route("/admin/booking/{id}/edit", name="admin_booking_edit")
     * @return response
     */
    public function edit(Booking $booking,Request $req, EntityManagerInterface $man)
    {

        $form = $this->createForm(AdminBookingType::class,$booking);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $man->persist($booking);
            $man->flush();

            $this->addFlash('success',"la réservation n° {$booking->getId()} a bien été modifier !");

            return $this->redirectToRoute('admin_booking_index');
        }


        return $this->render('admin/admin_booking/edit.html.twig', [
            'form'=>$form->createView(),
            'booking'=>$booking
        ]);

    }
}
