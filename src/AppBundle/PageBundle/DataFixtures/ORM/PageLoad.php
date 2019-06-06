<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 23.05.2019
 * Time: 14:48
 */

namespace AppBundle\PageBundle\DataFixtures\ORM;
use AppBundle\CommentBundle\Entity\Comment;
use AppBundle\TermBundle\DataFixtures\ORM\TermLoad;
use AppBundle\TermBundle\Entity\Term;
use AppBundle\UserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\PageBundle\Entity\Page;


class PageLoad extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager){
        $termRepo = $manager->getRepository(Term::class);
        $userRepo = $manager->getRepository(User::class);
        $user = $userRepo->findOneByUsername('Admin');
        for($i = 1; $i <=3; $i++){
            $page = new Page();
            $page->setTitle('Page '.$i);
            $page->setBody('Body page '.$i);
            $term = $termRepo->findOneByName('Term '.$i);
            $page->setCreated(new \DateTime());
            if($term && $user){
                $page->setCategory($term);
                $page->setUser($user);
            }
            $manager->persist($page);
        }
        $manager->flush();
    }

    public function getDependencies(){
        return [
            TermLoad::class
         ];
    }
}
