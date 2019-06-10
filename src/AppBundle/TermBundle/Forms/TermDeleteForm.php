<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 27.05.2019
 * Time: 13:20
 */

namespace AppBundle\TermBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TermDeleteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id',HiddenType::class, [
            'data' => $options['delete_id']
        ])->add('submit', SubmitType::class, [
            'label' => 'Delete',
            'attr' => [
                'class' => 'btn btn-danger btn-lg btn-block'
            ]
        ]);
    }
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['delete_id'] = $options['delete_id'];
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'delete_id' => null
        ]);
    }
}