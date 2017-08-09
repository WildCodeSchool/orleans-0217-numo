<?php

namespace NumoBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NumoBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat1 = new Category();
        $cat1->setName('Hackathon');
        $manager->persist($cat1);

        $cat2 = new Category();
        $cat2->setName('Meetup');
        $manager->persist($cat2);

        $cat3 = new Category();
        $cat3->setName('Conférence');
        $manager->persist($cat3);

        $cat4 = new Category();
        $cat4->setName('Startup Weekend');
        $manager->persist($cat4);

        $manager->flush();

    }
}