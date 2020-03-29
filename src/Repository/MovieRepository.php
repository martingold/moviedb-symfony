<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * @return array<Movie>
     */
    public function latestMovies(): array
    {
        return $this->getEntityManager()->getRepository(Movie::class)
            ->createQueryBuilder('movie')
            ->orderBy('movie.created', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<Movie>
     */
    public function bestMovies(): array
    {
        return $this->getEntityManager()->getRepository(Movie::class)
            ->createQueryBuilder('movie')
            ->where('movie.overallRating IS NOT NULL')
            ->orderBy('movie.overallRating', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

    public function update(Movie $movie)
    {
        $this->getEntityManager()->persist($movie);
        $this->getEntityManager()->flush();
    }

}
