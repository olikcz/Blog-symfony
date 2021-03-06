<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 31.05.2019
 * Time: 14:10
 */

namespace AppBundle\UserBundle\Controller;

use AppBundle\UserBundle\Entity\Role;
use AppBundle\UserBundle\Entity\User;
use AppBundle\UserBundle\Forms\DeleteRoleForm;
use AppBundle\UserBundle\Forms\RegisterForm;
use AppBundle\UserBundle\Forms\RoleForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('@User/Page/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $role = new Role();
        $form = $this->createForm(RegisterForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $role->setName('USER');
            $role->setRole('ROLE_USER');
            $user->addRole($role);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            return $this->redirectToRoute('login');
        }
        return $this->render('@User/Page/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
    public function addRoleAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $form = $this->createForm(RoleForm::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $roleUserForm = $form->getData();
            $user = $userRepo->find($roleUserForm['user']->getId());
            $user->addRole($roleUserForm['role']);
            $em->persist($user);
            $em->flush();
        }
        return $this->render('@User/Page/role.html.twig',[
            'roleForm' => $form->createView()
        ]);
    }

    public function deleteRoleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $form = $this->createForm(DeleteRoleForm::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $roleUserForm = $form->getData();
            $user = $userRepo->find($roleUserForm['user']->getId());
            $user->removeRole($roleUserForm['role']);
            $em->persist($user);
            $em->flush();

//            removeRole

        }
        return $this->render('@User/Page/deleteRole.html.twig',[
            'roleForm' => $form->createView()
        ]);
    }
}



