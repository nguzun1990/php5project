<?php
namespace Advert\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=20)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Advert", mappedBy="category", fetch="LAZY")
     * @ORM\JoinColumn(name="id", referencedColumnName="category_id")
     */
    private $advert;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->advert = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add advert
     *
     * @param \Advert\GeneralBundle\Entity\Advert $advert
     *
     * @return Category
     */
    public function addAdvert(\Advert\GeneralBundle\Entity\Advert $advert)
    {
        $this->advert[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \Advert\GeneralBundle\Entity\Advert $advert
     */
    public function removeAdvert(\Advert\GeneralBundle\Entity\Advert $advert)
    {
        $this->advert->removeElement($advert);
    }

    /**
     * Get advert
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Implemeted magic methode __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

}