<?php
namespace Paper\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paper
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="OrderRepository")
 */
class Order extends BaseEntity
{

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = "Введите название бумаги" )
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime", length=255)
     * @Assert\NotBlank( message = "Введите дату сдачи заказа" )
     */
    protected $end;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="FrozenPaper", mappedBy="order")
     */
    protected $papers;

    /**
     * @ORM\OneToMany(targetEntity="MarriagePaper", mappedBy="order")
     */
    protected $marriages;


    /**
     * @ORM\Column(type="integer")
     */
    protected $status = 0;

    public function __construct(){
        $this->papers = new ArrayCollection();
        $this->created = new \DateTime();
        $this->marriages = new ArrayCollection();
    }

    /**
     * @param mixed $papers
     */
    public function setPapers($papers)
    {
        $this->papers = $papers;
    }

    /**
     * @return mixed
     */
    public function getPapers()
    {
        return $this->papers;
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
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @param mixed $status
     */
    public function setStatus($status = 0)
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

    public function isAllHold(){
        $papers = $this->papers;
        foreach ($papers as $paper){
            if ( $paper->getStatus() != 2 ){
                return false;
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
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
