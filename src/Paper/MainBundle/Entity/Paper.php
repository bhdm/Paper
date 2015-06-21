<?php
namespace Paper\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paper
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PaperRepository")
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
     * @ORM\OneToMany(targetEntity="FrozenPaper", mappedBy="paper")
     */
    protected $orders;

    /**
     * @ORM\Column(type="integer")
     */
    protected $frozen = 0;

    /**
     * @ORM\ManyToOne(targetEntity="PaperType", inversedBy="papers")
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="MarriagePaper", mappedBy="paper")
     */
    protected $marriages;

    public function __construct(){
        $this->orders = new ArrayCollection();
        $this->created = new \DateTime();
        $this->marriages = new ArrayCollection();
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


    public function __toString(){
        return $this->title;
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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getMarriages()
    {
        return $this->marriages;
    }

    /**
     * @param mixed $marriages
     */
    public function setMarriages($marriages)
    {
        $this->marriages = $marriages;
    }


}
