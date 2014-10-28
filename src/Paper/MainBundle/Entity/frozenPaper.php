<?php
namespace Paper\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * таблица связывающая бумагу и заказ через себя
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class frozenPaper extends BaseEntity
{

    protected $order;

    protected $paper;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = 0;

}