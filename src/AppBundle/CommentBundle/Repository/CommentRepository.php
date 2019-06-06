<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 27.05.2019
 * Time: 22:36
 */

namespace AppBundle\CommentBundle\Repository;


use AppBundle\PageBundle\Entity\Page;
use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function findLastComments(Page $page, $limit = 20)
    {
        $query = $this->createQueryBuilder('c');
        $query->where('c.page = :page');
        $query->setParameter('page', $page);
        $query->setMaxResults($limit);
        $query->orderBy('c.parent_comment_id', 'ASC');
        return $query->getQuery()->getResult();
    }

    public function findLast(){
        $query = $this->createQueryBuilder('c')->select('MAX(c.id)');
        return $query->getQuery()->getSingleResult();
    }
    public function findThread($id){
//        $query = $this->createQueryBuilder('c');
//        $query->where('c.parent_comment_id = :id');
//        $query->setParameter('id',$id);
//        return $query->getQuery()->getResult();

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM comment c
        WHERE c.parent_comment_id = :id        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

    }

    public function findComments(Page $page, $pager = 1, $limit = 10)
    {
        $query = $this->createQueryBuilder('c');
        $query->where('c.page = :page')->setParameter('page', $page);
        $query->setMaxResults($limit);
        $query->setFirstResult(($limit * $pager) - $limit);
        return $query->getQuery()->getResult();
    }

    public function countComments(Page $page)
    {
        $query = $this->createQueryBuilder('c')->select('count(c.id)');
        $query->where('c.page = :page')->setParameter('page', $page);
        $result = $query->getQuery()->getOneOrNullResult(); // 1 => 3
        return $result ? array_shift($result) : 0;
    }

}