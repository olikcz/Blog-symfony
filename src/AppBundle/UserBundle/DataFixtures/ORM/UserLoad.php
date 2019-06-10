<?php
namespace AppBundle\UserBundle\DataFixtures\ORM;

use AppBundle\UserBundle\DataFixtures\ORM\RoleLoad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\UserBundle\Entity\Role;
use AppBundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserLoad extends Fixture implements FixtureInterface, ContainerAwareInterface  {
    public function load(ObjectManager $manager) {

        // created user account
        $roleUser = new Role();
        $roleUser->setName('USER');
        $roleUser->setRole('ROLE_USER');
        $user = new User();
        $user->setUsername('user');
        $encoder = $this->container->get('security.password_encoder');
        $user->setPassword($encoder->encodePassword($user, '123456'));
        $user->addRole($roleUser);

        $user->setEmail('user@user.com');
        $manager->persist($user);
        $manager->flush();

        // created admin account
        $role = new Role();
        $role->setName('ADMIN');
        $role->setRole('ROLE_ADMIN');
        $admin = new User();
        $admin->setUsername('admin');
        $encoder = $this->container->get('security.password_encoder');
        $admin->setPassword($encoder->encodePassword($admin, '123456'));
        $admin->addRole($role);
        $admin->setEmail('admin@admin.com');
        $manager->persist($admin);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            RoleLoad::class
        ];
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}