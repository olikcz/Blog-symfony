<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 04.06.2019
 * Time: 11:27
 */

namespace AppBundle\UserBundle\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->add('username');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}