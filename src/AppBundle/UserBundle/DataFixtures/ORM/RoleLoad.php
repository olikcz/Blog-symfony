<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 02.06.2019
 * Time: 12:29
 */
namespace AppBundle\UserBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\UserBundle\Entity\Role;
class RoleLoad extends Fixture{

    public function load(ObjectManager $manager) {
//        $roleRepo = $manager->getRepository(Role::class);
//        $role = $roleRepo->findByRole('ROLE_USER');
//        if(!$role){
//        $role = new Role();
//        $role->setName("ROLE USER");
//        $role->setRole("ROLE_USER");
//        $manager->persist($role);
//        $manager->flush();

    }
}