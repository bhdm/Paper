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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="FrozenPaper", mappedBy="order")
     */
    protected $papers;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = 0;

    public function __construct(){
        $this->papers = new ArrayCollection();
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



}
