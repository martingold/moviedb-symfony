<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getByRatingsCount()
    {
        return $this->getEntityManager()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->select(['u', 'r'])
            ->leftJoin('u.ratings', 'r')
            ->orderBy('COUNT(r)', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
