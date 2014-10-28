<?php
namespace Paper\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('created' => 'DESC'));
    }
}