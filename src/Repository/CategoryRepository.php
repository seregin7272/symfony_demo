<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findAllOrdered()
    {
        /*$dql = 'SELECT cat FROM App\Entity\Category cat ORDER BY cat.name DESC';
        $query = $this->getEntityManager()->createQuery($dql);*/

        $qb = $this->createQueryBuilder('cat')
            ->addOrderBy('cat.name', 'ASC');

        $this->addFortuneCookieJoinAndSelect($qb);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function search($term)
    {
        $qb = $this->createQueryBuilder('cat')
            ->andWhere('cat.name LIKE :searchTerm
                OR cat.iconKey LIKE :searchTerm
                OR fc.fortune LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $term . '%');

        $this->addFortuneCookieJoinAndSelect($qb);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findWithFortunesJoin($id)
    {
        $qb = $this->createQueryBuilder('cat')
            ->andWhere('cat.id = :id')
            ->setParameter('id', $id);

        $this->addFortuneCookieJoinAndSelect($qb);

        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * Joins over to cat.fortuneCookies AND selects its fields
     *
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    private function addFortuneCookieJoinAndSelect(QueryBuilder $qb)
    {
        return $qb->leftJoin('cat.fortuneCookies', 'fc')
            ->addSelect('fc');
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
