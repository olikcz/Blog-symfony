<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 31.05.2019
 * Time: 14:13
 */

namespace AppBundle\UserBundle\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username')->add('_password', PasswordType::class);

    }
}