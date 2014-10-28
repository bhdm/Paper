<?php
namespace Paper\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Printer
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Printer extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = "Введите название бумаги" )
     */
    protected $title;


    /**
     * @ORM\OneToMany(targetEntity="FrozenPaper", mappedBy="printer")
     */
    protected $orders;


    public function __construct(){
        $this->orders = new ArrayCollection();
        $this->orders = new ArrayCollection();
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
