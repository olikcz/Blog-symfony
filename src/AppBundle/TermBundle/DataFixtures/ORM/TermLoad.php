<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 23.05.2019
 * Time: 14:48
 */

namespace AppBundle\TermBundle\DataFixtures\ORM;
use AppBundle\TermBundle\Entity\Term;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TermLoad extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i <= 3; $i++){
            $term = new Term();
            $term->setName("Category ".$i);
            $term->setDescription('Description '.$i);
            $manager->persist($term);
        }
        $manager->flush();
    }
}


