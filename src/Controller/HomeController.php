<?php


namespace App\Controller;



use App\Entity\Hotel;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $hotel = new Hotel();
        $hotel->setName('');

        $room = new Room();
        $room->getCapacity();

        $formHotel = $this->createForm(Hotel::class, $hotel);
        $formRoom = $this->createForm(Room::class, $hotel);

        return $this->render('base.html.twig', [
            'formHotel' => $formHotel,
            '$formRoom' => $formRoom
        ]);
    }
}