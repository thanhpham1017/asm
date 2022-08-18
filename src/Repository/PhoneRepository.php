<?php

namespace App\Repository;

use App\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Phone>
 *
 * @method Phone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phone[]    findAll()
 * @method Phone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phone::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Phone $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Phone $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    //SQL: SELECT * FROM Phone ORDER BY id DESC
    //Purpose: Newest phones will be displayed first
    //DQL (Doctrine Query Language)
    public function sortPhoneByIdDesc()
    {
        return $this->createQueryBuilder('phone')
            ->orderBy('phone.id', 'DESC')
            //ASC: Ascending (tăng dần)
            //DESC: Descending (giảm dần)
            ->getQuery()
            ->getResult()
        ;
    }

    public function sortPhonePriceAsc()
    {
        return $this->createQueryBuilder('phone')
            ->orderBy('phone.price', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function sortPhonePriceDesc()
    {
        return $this->createQueryBuilder('phone')
            ->orderBy('phone.price', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    //SQL: SELECT * FROM Phone WHERE title LIKE % 'keyword' %
    public function searchPhone($keyword) 
    {
        return $this->createQueryBuilder('phone')
            ->andWhere('phone.title LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')
            ->orderBy('phone.price', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }
}
