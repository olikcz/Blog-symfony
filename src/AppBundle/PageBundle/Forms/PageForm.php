<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 25.05.2019
 * Time: 14:50
 */

namespace AppBundle\PageBundle\Forms;

use AppBundle\TermBundle\Entity\Term;
use AppBundle\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class PageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')->add('body');
        $builder->add('category', EntityType::class, [
            'class' => Term::class,
            'choice_label' => 'name',
            'label' => 'Category'

        ]);
        $builder->add('created');
        $builder->add('submit', SubmitType::class, [
            'label' => 'Save'
        ]);
    }

}