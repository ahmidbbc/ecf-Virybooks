<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $capacity;

    /**
     * @ORM\Column(type="smallint")
     */
    private $price;

    /**
     * @ORM\Column(type="smallint")
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="id_room")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="room")
     */
    private $id_booking;

    public function __construct()
    {
        $this->id_booking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getIdBooking(): Collection
    {
        return $this->id_booking;
    }

    public function addIdBooking(Booking $idBooking): self
    {
        if (!$this->id_booking->contains($idBooking)) {
            $this->id_booking[] = $idBooking;
            $idBooking->setRoom($this);
        }

        return $this;
    }

    public function removeIdBooking(Booking $idBooking): self
    {
        if ($this->id_booking->contains($idBooking)) {
            $this->id_booking->removeElement($idBooking);
            // set the owning side to null (unless already changed)
            if ($idBooking->getRoom() === $this) {
                $idBooking->setRoom(null);
            }
        }

        return $this;
    }


}
