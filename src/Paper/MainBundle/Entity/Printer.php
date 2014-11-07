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
    protected $papers;


    public function __construct(){
        $this->papers = new ArrayCollection();
    }

    public function __toString(){
        return $this->title;
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



}
