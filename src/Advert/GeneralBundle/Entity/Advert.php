<?php
namespace Advert\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;
use Advert\GeneralBundle\Validator\Constraints as AdvertAssert;

/**
 * Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="advert")
 * @FileStore\Uploadable
 */
class Advert
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message = "advert.title.not_blank")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=10000, nullable=false)
     * @Assert\NotBlank(message = "advert.content.not_blank")
     */
    protected $content;

    /**
     * @ORM\Column(type="integer", length=15, nullable=false)
     * @Assert\NotBlank(message = "advert.price.not_blank")
     * @Assert\Type(type="numeric", message = "advert.price.not_valid")
     */
    protected $price;

    /**
     * @ORM\ManyToOne(targetEntity="Region", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank(message = "advert.region.not_blank")
     * @return integer
     */
    private $region;

    /**
     * @ORM\Column(name="region_id", type="integer", length=10, nullable=false)
     */
    private $regionId;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     * @Assert\NotBlank(message = "advert.zipcode.not_blank")
     */
    protected $zipcode;

    /**
     * @ORM\ManyToOne(targetEntity="Category", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank(message = "advert.category.not_blank")
     * @return integer
     */
    private $category;

    /**
     * @ORM\Column(name="category_id", type="integer", length=10, nullable=false)
     */
    private $categoryId;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     * @Assert\NotBlank(message = "advert.type.not_blank")
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message = "advert.name.not_blank")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message = "advert.email.not_blank")
     * @Assert\Email(message = "advert.email.not_valid")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message = "advert.phone.not_blank")
     * @AdvertAssert\ContainsNumeric(message = "advert.phone.not_valid")
     */
    protected $phone;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Assert\Image( maxSize="20M")
     * @FileStore\UploadableField(mapping="photo")
     * */
    protected $photo;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

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
     * Set title
     *
     * @param string $title
     *
     * @return Advert
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
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Advert
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set regionId
     *
     * @param integer $regionId
     *
     * @return Advert
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * Get regionId
     *
     * @return integer
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return Advert
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Advert
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Advert
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Advert
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set region
     *
     * @param \Advert\GeneralBundle\Entity\Region $region
     *
     * @return Advert
     */
    public function setRegion(\Advert\GeneralBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Advert\GeneralBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set category
     *
     * @param \Advert\GeneralBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function setCategory(\Advert\GeneralBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Advert\GeneralBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Advert
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Advert
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Advert
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set photo
     *
     * @param array $photo
     *
     * @return Advert
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return array
     */
    public function getPhoto()
    {
        return $this->photo;
    }

}