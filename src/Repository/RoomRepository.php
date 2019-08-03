<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Hotel;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PDO;
use PDOStatement;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Room::class);
    }

    /**
     * @param string $startedAt
     * @param string $endedAt
     * @return mixed
     */
    public function getRoomByAvailability($startedAt = '2019-08-03', $endedAt = '2019-08-31')
    {
        $req = new PDO("mysql://root:@127.0.0.1:3306/viryBooks", "root", '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $qb = $req->prepare("SELECT * FROM virybooks.room WHERE room.id NOT IN(SELECT room_id FROM virybooks.booking where started_at=:start AND ended_at=:end)");
        $qb->execute(array(
            'start' => $startedAt,
            'end' => $endedAt
        ));

        return $qb->fetchAll();
    }

    // /**
    //  * @return Room[] Returns an array of Room objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Room
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
