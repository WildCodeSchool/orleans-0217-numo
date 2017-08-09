<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 25/07/17
 * Time: 09:15
 */

namespace NumoBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NumoBundle\Entity\Company;


class LoadCompanyData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $company = new Company();
        $company->setContactEmail('numo@gmail.com');
        $company->setCity('Orléans');
        $company->setPostalCode(45100);
        $company->setAddress('1, avenue du champ de mars');
        $company->setPhone('06.06.06.06.06');
        $company->setPresentationTitle('Num\'O');
        $company->setPresentationContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum ante 
        vitae aliquam accumsan. Phasellus in ultrices purus. Ut vestibulum vestibulum nisi ut hendrerit. Donec feugiat 
        orci sodales leo eleifend, vel consectetur nisl tincidunt. Nulla facilisi. Curabitur diam sapien, sollicitudin 
        quis nisl maximus, eleifend pulvinar nibh. Aliquam dictum bibendum dui, ac accumsan est scelerisque sit amet. 
        Etiam aliquet risus et faucibus varius. Duis vitae accumsan sapien. Sed a massa arcu.

        Praesent libero arcu, fringilla quis pretium vel, porttitor eget quam. Nulla sodales elit nec urna sollicitudin 
        congue vitae eu mauris. Vestibulum in mi id odio iaculis rutrum sit amet at diam. In sit amet finibus orci. 
        Proin eget porta libero. Aliquam tempus ligula enim, id ornare leo feugiat sed. Proin fringilla iaculis 
        ullamcorper. Etiam imperdiet lectus erat, eget fermentum elit porttitor vel. Sed commodo imperdiet est vitae 
        tempus. Fusce nec accumsan quam, quis porttitor nunc. Vivamus felis neque, convallis tempor orci eu, feugiat 
        commodo est. Phasellus pharetra ipsum ultricies placerat blandit. Cras efficitur gravida turpis sagittis 
        rutrum. ');
        $company->setAdherentTitle('Devenez Adherent');
        $company->setAdherentContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum ante 
        vitae aliquam accumsan. Phasellus in ultrices purus. Ut vestibulum vestibulum nisi ut hendrerit. Donec feugiat 
        orci sodales leo eleifend, vel consectetur nisl tincidunt. Nulla facilisi. Curabitur diam sapien, sollicitudin 
        quis nisl maximus, eleifend pulvinar nibh. Aliquam dictum bibendum dui, ac accumsan est scelerisque sit amet. 
        Etiam aliquet risus et faucibus varius. Duis vitae accumsan sapien. Sed a massa arcu.

        Praesent libero arcu, fringilla quis pretium vel, porttitor eget quam. Nulla sodales elit nec urna sollicitudin 
        congue vitae eu mauris. Vestibulum in mi id odio iaculis rutrum sit amet at diam. In sit amet finibus orci. 
        Proin eget porta libero. Aliquam tempus ligula enim, id ornare leo feugiat sed. Proin fringilla iaculis 
        ullamcorper. Etiam imperdiet lectus erat, eget fermentum elit porttitor vel. Sed commodo imperdiet est vitae 
        tempus. Fusce nec accumsan quam, quis porttitor nunc. Vivamus felis neque, convallis tempor orci eu, feugiat 
        commodo est. Phasellus pharetra ipsum ultricies placerat blandit. Cras efficitur gravida turpis sagittis 
        rutrum. ');
        $company->setImageUrl('NUMOmedium.png');
        $company->setPdf('5964d564f2669.pdf');


        $manager->persist($company);
        $manager->flush();
    }
}