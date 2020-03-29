<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    /**
     * @return array<\App\Entity\Rating>
     */
    public function findByMovie(Movie $movie): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.movie = :movie')
            ->setParameter('movie', $movie)
            ->orderBy('r.created', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findUserRating(Movie $movie, User $user): ?Rating
    {
        return $this->createQueryBuilder('r')
            ->where('r.movie = :movie')
            ->andWhere('r.user = :user')
            ->setParameters([
                'movie' => $movie,
                'user' => $user,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return array<Rating>
     */
    public function getLatestRatings(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.created', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

}
