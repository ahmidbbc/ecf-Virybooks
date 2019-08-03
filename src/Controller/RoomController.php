<?php

namespace App\Controller;

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
        $startedAt = filter_input(INPUT_POST, "statedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"[^0-9/]")));
        $endedAt = filter_input(INPUT_POST, "endedAt", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"[^0-9/]")));


        $roomRepo = $this->em->getRepository(Room::class);
        $roomLists = $roomRepo->getRoomByAvailability($startedAt, $endedAt);

        return $this->render('room/index.html.twig', [
            'roomLists' => $roomLists,
            'startedAt' => $startedAt,
            'endedAt' => $endedAt
        ]);
    }
}
