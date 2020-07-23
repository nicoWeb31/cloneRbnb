<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * 
 * Exiplique a doctrine que l'entités doit gerer son cycle de vie
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ad")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Ad::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface",message="attention la date doit etre au bon format")
     * @Assert\GreaterThan("today", message="la date d'arriver doit etre supperieur a la date d'aujourd'hui")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface",message="attention la date doit etre au bon format")
     * @Assert\GreaterThan(propertyPath = "startDate", message="la date de depart ne peut pas etre inferieur a la date d'arrivée saucisse !")
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     */
    private $comment;


    /**
     * permet de recuperer un tableau des journnéés qui corespondes a ma resevation
     * @return array
     */
    public function getDays()
    {
        $reslut = range($this->getStartDate()->getTimestamp(),
        $this->getEndDate()->getTimestamp(),
         24 * 60 * 60);

        $days = array_map(function($dayTimesStamp){
            return new \DateTime(date('Y-m-d', $dayTimesStamp));
        }, $reslut);

        return $days;
    }



    /**
     * regarder si les dates sont disponibles
     * @return bool
     */
    public function isBookingDates()
    {

        $formatDay = function($day){
            return $day->format('Y-m-d');
        };

        //connaitre les dates impossible 
        $notAvailableDays = $this->ad->getNotAvailableDAys();

        //comparer avec les dates choisis
        $bookingDays = $this->getDays();

        //tableau qui convertit les timstapm e, chaine de carac 
        $days = array_map($formatDay,$bookingDays);

        //tableau qui convertit les timstamp, chaine de carac 
        $NotAvailable = array_map($formatDay,$notAvailableDays);

        foreach($days as $day){
            if (array_search($day, $NotAvailable) !== false) return false;
        }
        return true;
    }
        


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }


    /**
     * Callback appeller a chaque resa
     * @ORM\PrePersist
     * @return void
     */
    
    public function prePersist(){
        if(empty($this->createAt)){
            $this->createAt = new \DateTime();
        }


        //prix de l'annonce
        if(empty($this->amount)){
            $this->amount = $this->getDuration() * $this->getAd()->getPrice();
        }
    }

    /**
     * recupere la durée du sejour
     */
    public function getDuration(){
        //diff methode date time renvoie la diff entre deux dates det type date interavle

        $diff = $this->endDate->diff($this->createAt);
        return $diff->days;
    }
}
