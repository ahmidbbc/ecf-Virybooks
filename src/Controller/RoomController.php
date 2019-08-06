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
        $dateRegex = '/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/';
        $startedAt = filter_input(INPUT_POST, "startedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$dateRegex)));
        $endedAt = filter_input(INPUT_POST, "endedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$dateRegex)));
        $guests = filter_input(INPUT_POST, "guests", FILTER_SANITIZE_STRING);


        $hotelRepo = $this->em->getRepository(Hotel::class);
        $hotelsList = $hotelRepo->getAllHotels();

        if($startedAt && $endedAt && $guests) {

            $roomRepo = $this->em->getRepository(Room::class);
            $roomLists = $roomRepo->getRoomByAvailability($startedAt, $endedAt, $guests);

            return $this->render('room/index.html.twig', [
                'roomLists' => $roomLists,
                'startedAt' => $startedAt,
                'endedAt' => $endedAt,
                'guests' =>$guests,
                'hotelsList' => $hotelsList
            ]);
        }
        return $this->render('hotel/index.html.twig', [
            'hotelsList' => $hotelsList
        ]);
    }
}
