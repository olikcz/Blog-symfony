<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 28.05.2019
 * Time: 10:44
 */

namespace AppBundle\PageBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    public function findPages($page = 1, $limit = 10){
        $query = $this->createQueryBuilder('p');
        $query->setMaxResults($limit);
        $query->setFirstResult( ($limit * $page) - $limit );
        return $query->getQuery()->getResult();
    }

    public function countPage(){
        $query = $this->createQueryBuilder('p')->select('count(p.id)');
        $result = $query->getQuery()->getOneOrNullResult(); // 1 => 3
        return $result ? array_shift($result) : 0;
    }

}