<?php
namespace Paper\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class FrozenPaperRepository extends EntityRepository
{
    public function filter($strats, $ends)
    {
        $result= $this
            ->createQueryBuilder('f')
            ->select('f')
            ->where("f.created >= '".$strats->format('Y-m-d')."00:00' ")
            ->andWhere("f.created <= '".$ends->format('Y-m-d')."23:59' ")
            ->getQuery()
            ->getResult();

        return $result;
    }
}