<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
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
            
            //si les date ne sont pas disponible on stop est on renvoi
            if(!$booking->isBookingDates()){
                $this->addFlash('warning', "Les dates que vous avez choisie ne sont pas disponible");
                
            }else{
                $man->persist($booking);
                $man->flush();
                return $this->redirectToRoute('booking_show', [
                    'id'=> $booking->getId(),
                    'success'=> true
                ]);
            }
            
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
     * @param Request $req
     * @param EntityManagerInterface $man
     * @return response
     */
    public function bookShow(Booking $booking,Request $req,EntityManagerInterface $man)
    {

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $comment->setAd($booking->getAd())
                    ->setAuthor($this->getUser());

            $man->persist($comment);
            $man->flush();
            
            $this->addFlash('success', 'Commentaire ajouter avec succes ! ');
        }


        return $this->render('booking/booking_show.html.twig',[
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }
}
