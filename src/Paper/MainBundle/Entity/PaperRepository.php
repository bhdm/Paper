<?php
namespace Paper\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PaperRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('title' => 'ASC'));
    }


}