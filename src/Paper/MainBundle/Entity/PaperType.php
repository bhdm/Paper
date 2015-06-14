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
class PaperType extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message = "Введите название типа бумаги" )
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Paper", mappedBy="type")
     */
    protected $papers;

    public function __construct(){
        $this->papers = new ArrayCollection();
        $this->created = new \DateTime();
    }

    public function __toString(){
        return $this->title;
    }
    /**
     * @return mixed
     */
    public function getTitle()
    {
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
    public function getPapers()
    {
        return $this->papers;
    }

    /**
     * @param mixed $papers
     */
    public function setPapers($papers)
    {
        $this->papers = $papers;
    }


}
