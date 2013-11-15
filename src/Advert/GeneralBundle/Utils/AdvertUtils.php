<?php
namespace Advert\GeneralBundle\Utils;

/**
 * AdvertUtils class - utils functions for the advert bundle
 */
class AdvertUtils
{

    /**
     * Check if parameter is a valid ID
     *
     * @param integer $id ID for an entity
     *
     * @return boolean
     */
    public static function isValidId($id)
    {
        if ((is_numeric($id)) && ($id != null) && ($id > 0)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

}

