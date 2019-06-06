<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 25.05.2019
 * Time: 10:42
 */

namespace AppBundle\CommentBundle\DataFixtures\ORM;


use AppBundle\CommentBundle\Entity\Comment;
use AppBundle\PageBundle\DataFixtures\ORM\PageLoad;
use AppBundle\PageBundle\Entity\Page;
use AppBundle\UserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentLoad extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pageRepo = $manager->getRepository(Page::class);
        $userRepo = $manager->getRepository(User::class);
        $user = $userRepo->findOneByusername('admin');
        $pages = $pageRepo->findAll();
        foreach ($pages as $page){
            for($i=1; $i <= 2; $i++){
                $comment = new Comment();
                $comment->setComment('Comment '.$i.' > '.$page->getTitle());
                $comment->setUser($user);
                $comment->setParentCommentId(1);
                $comment->setIsDeleted(false);
                $page->addComment($comment);
                $comment->setPage($page);
            }
            $manager->persist($page);
        }
        $manager->flush();
    }

    function getDependencies()
    {
        return [
            PageLoad::class
        ];
    }
}