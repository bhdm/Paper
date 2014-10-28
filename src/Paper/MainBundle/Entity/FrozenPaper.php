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
class FrozenPaper extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="papers")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Paper", inversedBy="orders")
     */
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