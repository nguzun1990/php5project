<?php

namespace Advert\GeneralBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Advert\GeneralBundle\Entity\Category;

/**
 * CategoryFixtures class
 */
class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * @param ObjectManager $manager object manager
     */
    public function load(ObjectManager $manager)
    {
        $categories = array("Automobile", "Bâtiments", "Technologie", "Autre");

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setTitle($categoryName);
            $manager->persist($category);
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
        return 2;
    }

}
