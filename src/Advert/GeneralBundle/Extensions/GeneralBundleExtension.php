<?php
namespace Advert\GeneralBundle\Extensions;

/**
 * CgvAdminBundleExtension class - twig extension
 */
class GeneralBundleExtension extends \Twig_Extension
{

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            'get_substring' => new \Twig_Filter_Method($this, 'getSubstring', array('length')),
            'formated_date' => new \Twig_Filter_Method($this, 'formatedDate'),
        );
    }

    /**
     * getSubstring
     *
     * @param string  $string string
     * @param integer $length length
     *
     * @return string
     */
    public function getSubstring($string, $length)
    {
        if (strlen($string) > $length) {
            $result = substr($string, 0, $length) . '...';
        } else {
            $result = $string;
        }

        return $result;
    }

    /**
     * formatedDate
     *
     * @param \DateTime $date DateTime Object
     *
     * @return string
     */
    public function formatedDate($date)
    {
        $nrWeekDay = $date->format('w');
        $weekDays = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
        $weekDay = $weekDays[$nrWeekDay];
        $nrMonth = $date->format('n');
        $months = array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
        $month = $months[$nrMonth];
        $monthDay = $date->format('d');
        $hour = $date->format('H');
        $minute = $date->format('i');
        $result = $weekDay . ' ' . $monthDay . ' ' . $month . ' a ' . $hour . 'h' . $minute;

        return $result;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return 'advert_general_extension';
    }

}

