<?php

namespace App\Controller;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HotelController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * HotelController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $hotelRepo = $this->em->getRepository(Hotel::class);
        $hotelsList = $hotelRepo->getAllHotels();


        return $this->render('hotel/index.html.twig', [     
            'hotelsList' => $hotelsList
        ]);
    }
}
