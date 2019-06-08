<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 08.06.2019
 * Time: 13:48
 */

namespace AppBundle\UserBundle\Forms;


use AppBundle\UserBundle\Entity\Role;
use AppBundle\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', EntityType::class,[
                'class' => Role::class,
                'choice_label' => 'role',
                'label' => 'select role'
            ])->
            add('user', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'select user'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}