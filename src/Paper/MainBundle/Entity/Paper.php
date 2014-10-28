<?php
namespace Paper\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paper
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Paper extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = "Введите название бумаги" )
     */
    protected $title;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count = 0;


    /**
     * @ORM\ManyToMany(targetEntity="Order", inversedBy="papers")
     */
    protected $orders;
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
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }


}