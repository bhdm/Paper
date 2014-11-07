<?php
namespace Paper\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('created' => 'DESC'));
    }


    public function hold($id)
    {
        $result= $this
            ->createQueryBuilder('o')
            ->select('SUM(f.count)')
            ->leftJoin('o.papers','f')
            ->where('o.id = '.$id)
            ->andWhere('f.status = 1')
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findOrderwithFrozen(){
        $result= $this
            ->createQueryBuilder('o')
            ->select('o')
            ->leftJoin('o.papers','f')
            ->where('f.status = 1')
            ->getQuery()
            ->getResult();

        return $result;
    }

}