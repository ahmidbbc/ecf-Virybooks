<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * RoomController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/rooms", name="rooms")
     */
    public function indexAction()
    {
        $dateRegex = "/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/";

        $hotel = filter_input(INPUT_POST, 'hotel', FILTER_SANITIZE_STRING);
        $startedAt = filter_input(INPUT_POST, "startedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$dateRegex)));
        $endedAt = filter_input(INPUT_POST, "endedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$dateRegex)));
        $guest = filter_input(INPUT_POST, 'guest', FILTER_SANITIZE_STRING);

        $hotelRepo = $this->em->getRepository(Hotel::class)->find($hotel);

        if(!empty($hotel) && !empty($startedAt) && !empty($endedAt) && !empty($guest)){

            if($startedAt && $endedAt) {
                $roomRepo = $this->em->getRepository(Room::class);
                $roomsList = $roomRepo->getRoomByAvailability($hotel, $startedAt, $endedAt, $guest);
            }

            return $this->render('room/index.html.twig', [
                'roomsList' => $roomsList,
                'startedAt' => $startedAt,
                'hotelName' => $hotelRepo->getName(),
                'endedAt' => $endedAt,
                'guest' => $guest
            ]);
        }

        return $this->render('hotel/index.html.twig', [
            'message' => 'Aucune chambre disponible pour les dates sélectionnées'
        ]);
    }
}
