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
class MarriagePaper extends BaseEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="marriages")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Paper", inversedBy="marriages")
     */
    protected $paper;

    /**
     * @ORM\Column(type="string")
     */
    protected $count;

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getPaper()
    {
        return $this->paper;
    }

    /**
     * @param mixed $paper
     */
    public function setPaper($paper)
    {
        $this->paper = $paper;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

}