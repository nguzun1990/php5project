<?php

namespace Advert\GeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Advert\GeneralBundle\Entity\Region;

/**
 * CategoryFixtures class
 */
class RegionFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @param ObjectManager $manager object manager
     */
    public function load(ObjectManager $manager)
    {
        $regions = array("Île-de-France", "Rhône-Alpes", "Provence-Alpes-Côte d'Azur", "Nord-Pas de Calais",
            "Pays de la Loire", "Aquitaine", "Brittany", "Midi-Pyrénées", "Languedoc-Roussillon", "Centre",
            "Lorraine", "Picardy", "Alsace", "Upper Normandy", "Poitou-Charentes", "Bourgogne",
            "Lower Normandy", "Auvergne", "Champagne-Ardenne", "Franche-Comté", "Réunion", "Limousin",
            "Guadeloupe", "Martinique", "Corse", "Guyane");
        foreach ($regions as $regionName) {
            $region = new Region();
            $region->setTitle($regionName);
            $manager->persist($region);
        }
        $manager->flush();
    }

    /**
     * Order of fixtures load
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

}
