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
            $page->setTitle('Lorem ipsum dolor sit amet '.$i);
            $page->setBody('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores iusto tempore voluptatum blanditiis impedit alias magni ullam facilis perspiciatis magnam cum dignissimos doloremque, repudiandae obcaecati dolor, quae voluptatem. Quia similique nihil nobis deleniti reiciendis veritatis commodi repudiandae beatae, molestias iusto, a numquam animi blanditiis aspernatur nam nulla illum repellendus sunt ea excepturi culpa laudantium in doloribus neque eum. Enim commodi eaque beatae nulla, labore et voluptates est iusto maxime molestias qui temporibus modi architecto magni repellat laboriosam impedit, ut nam, perspiciatis porro ipsa eos voluptatibus. Ipsa iusto rem quasi velit eum quibusdam necessitatibus perspiciatis hic, fugiat, illum, accusamus. Ducimus, eum saepe exercitationem fugit ipsa quia, omnis accusamus earum velit impedit iusto tenetur dicta, repellendus deleniti sapiente ullam quae at. Corrupti quis quidem adipisci et dolores autem amet illum molestiae, quam doloribus accusantium labore tenetur debitis perspiciatis id est quia voluptates similique nisi pariatur, quisquam esse assumenda laborum eos libero? Et nobis non, beatae deserunt fugiat. Nulla voluptatibus hic velit ad laudantium quod reprehenderit, dolorum vel dolores, atque veniam vitae, ut adipisci ducimus, tempore dolorem. Recusandae eius quo blanditiis quibusdam possimus, praesentium dicta, asperiores dignissimos ipsum. Velit eaque magnam consequuntur voluptatibus dolore doloribus, nulla facilis. Saepe et quaerat vitae rem, esse vero minima harum ut natus, quo, debitis totam consequuntur tempora eos perferendis earum temporibus quibusdam quos labore sequi quod. Voluptates, consectetur? Quaerat voluptate perferendis sunt iusto, ad itaque. Officia, perspiciatis suscipit cupiditate. Aliquid quo, non eligendi blanditiis rerum harum voluptate quia soluta natus, similique optio, incidunt facere quod atque sint minus provident. Laudantium est consequuntur dolor, aspernatur expedita. Ullam, tempora impedit! Rem nisi facilis cumque reiciendis eaque, a quam ab recusandae molestias enim eum suscipit soluta expedita odit maxime provident quos cupiditate! Minima, sapiente. Assumenda odit placeat quod, quas accusantium reiciendis vitae aliquid blanditiis quisquam non facere, sint in ad.');
            $term = $termRepo->findOneByName('Category '.$i);
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
