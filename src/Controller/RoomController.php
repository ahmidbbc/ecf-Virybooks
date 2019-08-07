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
        //if checkdate ( int $month , int $day , int $year ) : bool o try/catch
        $startedAt = filter_input(INPUT_POST, "startedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/")));
        $endedAt = filter_input(INPUT_POST, "endedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/")));
        $guest = filter_input(INPUT_POST, 'bookings', FILTER_SANITIZE_STRING);


        $hotelRepo = $this->em->getRepository(Hotel::class);
        $hotelsList = $hotelRepo->getAllHotels();

        $roomRepo = $this->em->getRepository(Room::class);
        $roomsList = $roomRepo->getRoomByAvailability($startedAt, $endedAt, $guest);

        if($startedAt && $endedAt) {

            return $this->render('room/index.html.twig', [
                'roomsList' => $roomsList,
                'hotelsList' => $hotelsList,
                'startedAt' => $startedAt,
                'endedAt' => $endedAt,
                'guest' => $guest
            ]);
        }

        return $this->render('hotel/index.html.twig', [
            'message' => 'Aucune chambre disponible pour les dates sélectionnées'
        ]);
    }
}
