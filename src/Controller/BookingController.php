<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $req, EntityManagerInterface $man)
    {

        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();
            $booking->setBooker($user);
            $booking->setAd($ad);
            

            $man->persist($booking);
            $man->flush();

            return $this->redirectToRoute('booking_show', [
                'id'=> $booking->getId(),
                'success'=> true
            ]);


        }


        return $this->render('booking/book.html.twig',[
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/booking/{id}", name="booking_show")
     * @IsGranted("ROLE_USER")
     * @param Booking $booking
     * @return response
     */
    public function bookShow(Booking $booking)
    {


        return $this->render('booking/booking_show.html.twig',[
            'booking' => $booking
        ]);
    }
}
