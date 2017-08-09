<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 25/07/17
 * Time: 10:28
 */

namespace NumoBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NumoBundle\Entity\PricingInfo;

class LoadPricingInfoData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $price1 = new PricingInfo();
        $price1->setPricing('gratuit');
        $manager->persist($price1);

        $price2 = new PricingInfo();
        $price2->setPricing('gratuit avec inscription');
        $manager->persist($price2);

        $price3 = new PricingInfo();
        $price3->setPricing('payant');
        $manager->persist($price3);

        $price4 = new PricingInfo();
        $price4->setPricing('payant sur place');
        $manager->persist($price4);

        $manager->flush();
    }
}