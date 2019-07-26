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
     * @Route("/aa", name="home")
     */
    public function indexAction()
    {
        $roomRepo = $this->em->getRepository(Room::class);
        $roomLists = $roomRepo->getRoomByAvailability();

        return $this->render('room/index.html.twig', [
            'roomLists' => $roomLists,
        ]);
    }
}
