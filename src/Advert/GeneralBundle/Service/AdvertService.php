<?php
namespace Advert\GeneralBundle\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Advert\GeneralBundle\Entity\Advert;
use Advert\GeneralBundle\Utils\AdvertUtils;
use Advert\GeneralBundle\Utils\AdvertServiceException;
use Advert\GeneralBundle\Utils\ServiceException;

/**
 * AdvertService class
 *
 */
class AdvertService
{

    /**
     *
     * @var EntityManager
     */
    private $emanager;

    /**
     * @var message for invalid object Id
     */
    static private $invalidIdMessage = 'Invalid Advert entity ID ';

    /**
     * @var message for not found object (entity)
     */
    static private $noFoundMessage = 'No found Advert with ID ';

    /**
     * @var message - if object is not of requiered class
     */
    static private $notInstanceOfMessage = 'Object is not instance of Advert class ';

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->emanager = $entityManager;
    }

    /**
     * Get Advert
     *
     * @param integer $advertId
     *
     * @return mixen Advert
     */
    public function get($advertId)
    {
        try {

            if (!AdvertUtils::isValidId($advertId)) {
                throw new ServiceException(self::$invalidIdMessage . $advertId);
            }
            $emanager = $this->emanager;
            $advert = $emanager->getRepository('AdvertGeneralBundle:Advert')->find($advertId);
            if ($advert == null) {
                throw new ServiceException(self::$noFoundMessage . $advertId);
            }

            return $advert;
        } catch (\Exception $exc) {
            throw new ServiceException('Error on get() method from AdvertService class: ' . $exc->getMessage());
        }
    }

    /**
     * Get list of adverts
     *
     * @param integer $limit - number of rows in the returned list
     *
     * @return Array array of adverts
     */
    public function getList($limit = null)
    {
        try {
            $emanager = $this->emanager;
            $advertList = $emanager->getRepository('AdvertGeneralBundle:Advert')->findBy(array(), array('createdAt' => 'DESC'), $limit);

            return $advertList;
        } catch (\Exception $exc) {
            throw new ServiceException('Error on getList() method from AdvertService class: ' . $exc->getMessage());
        }
    }

    /**
     * Update an advert
     *
     * @param object $advert Advert
     *
     * @return  boolean success
     */
    public function update($advert)
    {
        $success = false;
        try {
            if (!($advert instanceof Advert)) {
                throw new ServiceException(self::$notInstanceOfMessage);
            }
            $advertId = $advert->getId();
            if (!AdvertUtils::isValidId($advertId)) {
                throw new ServiceException(self::$invalidIdMessage . $advertId);
            }

            $emanager = $this->emanager;
            $emanager->persist($advert);
            $emanager->flush();
            $success = true;
        } catch (\Exception $exc) {
            throw new ServiceException('Error on update() method from AdvertService class: ' . $exc->getMessage());
        }

        return $success;
    }

    /**
     * Insert an advert
     *
     * @param object $advert Advert
     *
     * @return  integer advertId
     */
    public function insert($advert)
    {
        $advertId = null;
        try {
            if (!($advert instanceof Advert)) {
                throw new notInstanceOfMessage(self::$notInstanceOfMessage);
            }
            $advert->setCreatedAt(new \DateTime());
            $emanager = $this->emanager;
            $emanager->persist($advert);
            $emanager->flush();
            $advertId = $advert->getId();
        } catch (\Exception $exc) {
            throw new ServiceException('Error on insert() method from AdvertService class: ' . $exc->getMessage());
        }

        return $advertId;
    }

    /**
     * Delete Advert
     *
     * @param integer $advertId
     *
     * @return mixed Advert
     */
    public function remove($advertId)
    {
        $success = false;
        try {
            if (!AdvertUtils::isValidId($advertId)) {
                throw new ServiceException(self::$invalidIdMessage . $advertId);
            }
            $emanager = $this->emanager;
            $advert = $emanager->getRepository('AdvertGeneralBundle:Advert')->find($advertId);
            if (!$advert) {
                throw new ServiceException(self::$noFoundMessage . $advertId);
            }
            $emanager->remove($advert);
            $emanager->flush();
            $success = true;
        } catch (\Exception $exc) {
            throw new ServiceException('Error on remove() method from AdvertService class: ' . $exc->getMessage());
        }

        return $success;
    }

    /**
     * Get list of adverts that containd searching sentence
     *
     * @param string $sentence Search string
     *
     * @return Array array of adverts
     */
    public function getListSearch($sentence)
    {
        try {
            $result = array();
            $sentence = strtolower($sentence);
            $words = explode(" ", $sentence);
            $emanager = $this->emanager;
            $adverts = $emanager->getRepository('AdvertGeneralBundle:Advert')->findBy(array(), array('createdAt' => 'DESC'));
            if ($sentence != '') {
                foreach ($adverts as $advert) {
                    $advertInfo = array();
                    $advertInfo[] = $advert->getTitle();
                    $advertInfo[] = $advert->getContent();
                    $advertInfo[] = $advert->getPrice();
                    $advertInfo[] = $advert->getRegion()->getTitle();
                    $advertInfo[] = $advert->getZipcode();
                    $advertInfo[] = $advert->getType();
                    $advertInfo[] = $advert->getName();
                    $advertInfo[] = $advert->getEmail();
                    $advertInfo[] = $advert->getPhone();
                    $advertInfo = implode(" ", $advertInfo);
                    $advertInfo = strtolower($advertInfo);
                    $add = false;
                    foreach ($words as $word) {
                        if (($word !== '') && (strpos($advertInfo, $word) !== false)) {
                            $add = true;
                        }
                    }
                    if ($add) {
                        $result[] = $advert;
                    }
                }
            } else {
                $result = $adverts;
            }

            return $result;
        } catch (\Exception $exc) {
            throw new ServiceException('Error on getListSearch() method from AdvertService class: ' . $exc->getMessage());
        }
    }

}
