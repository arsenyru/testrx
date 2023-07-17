<?php

namespace App\Repository;

use App\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weather>
 *
 * @method Weather|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weather|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weather[]    findAll()
 * @method Weather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Weather::class);
    }

    /** @return Weather[]|null */
    public function getWeatherForNext3Days() {
         return $this->createQueryBuilder('w')
             ->select('w')
             ->where('w.date >= current_date()')
             ->orderBy('w.date')
             ->setMaxResults(3)
             ->getQuery()
             ->getResult();
    }
}
