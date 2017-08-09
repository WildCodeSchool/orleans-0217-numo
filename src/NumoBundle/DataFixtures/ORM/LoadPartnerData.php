<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 25/07/17
 * Time: 10:23
 */

namespace NumoBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NumoBundle\Entity\Partner;

class LoadPartnerData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $partner1 = new Partner();
        $partner1->setName('Wild Code School');
        $partner1->setWebUrl('www.wildcodeschool.com');
        $partner1->setImageUrl('59649c4da34f0.png');
        $partner1->setActive(1);
        $manager->persist($partner1);

        $partner2 = new Partner();
        $partner2->setName('Le Lab\'O');
        $partner2->setWebUrl('www.labo.com');
        $partner2->setImageUrl('logolabo.png');
        $partner2->setActive(1);
        $manager->persist($partner2);

        $manager->flush();
    }
}