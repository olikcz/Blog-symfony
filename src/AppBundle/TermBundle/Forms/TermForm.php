<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 27.05.2019
 * Time: 12:43
 */

namespace AppBundle\TermBundle\Forms;


use AppBundle\TermBundle\Entity\Term;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TermForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add('submit', SubmitType::class, [
            'label' => 'Save'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Term::class);
    }
}