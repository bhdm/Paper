<?php
namespace Paper\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * таблица связывающая бумагу и заказ через себя
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FrozenPaperRepository")
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
    protected $paper ;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $frozen = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $color = false;

    /**
     * @ORM\Column(type="integer")
     */
    protected $typePrint = 1;

    /**
     * @ORM\ManyToOne(targetEntity="Printer", inversedBy="papers")
     */
    protected $printer;

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
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
    public function getOrder()
    {
        return $this->order;
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
    public function getPaper()
    {
        return $this->paper;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $typePrint
     */
    public function setTypePrint($typePrint)
    {
        $this->typePrint = $typePrint;
    }

    /**
     * @return mixed
     */
    public function getTypePrint()
    {
        return $this->typePrint;
    }

    /**
     * @param mixed $printer
     */
    public function setPrinter($printer)
    {
        $this->printer = $printer;
    }

    /**
     * @return mixed
     */
    public function getPrinter()
    {
        return $this->printer;
    }

    /**
     * @param mixed $frozen
     */
    public function setFrozen($frozen = 0)
    {
        $this->frozen = $frozen;
    }

    /**
     * @return mixed
     */
    public function getFrozen()
    {
        return $this->frozen;
    }





}