<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\SmsSender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 5;

    /**
     * PostRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getListPaginator($keywords, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->setMaxResults(self::PAGINATOR_PER_PAGE) // LIMIT 10
            ->setFirstResult($offset) // LIMIT 0, 10
            ->getQuery()
        ;

        return new Paginator($query);
    }

    public function search($k, $locale)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                post.id, 
                post.published_at, 
                post_translation.name,
                post_translation.description
            FROM post
            INNER JOIN post_translation ON post_translation.translatable_id = post.id
            WHERE 
                post_translation.locale = :locale
                AND
                (post_translation.name LIKE :keyword OR post_translation.description LIKE :keyword)
            ORDER BY 
                 post.published_at DESC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'locale' => $locale,
            'keyword' => '%' . $k . '%'
        ]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
