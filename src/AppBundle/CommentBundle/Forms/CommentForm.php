<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 27.05.2019
 * Time: 15:22
 */

namespace AppBundle\CommentBundle\Forms;


use AppBundle\CommentBundle\Entity\Comment;
use AppBundle\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('comment', TextareaType::class, [

                'attr' => array('maxlength' => 1000)

        ]);
        $builder->add('submit',SubmitType::class,[
            'label' => 'Add coment',
            'attr' => ['class' => 'btn btn-success']

        ]);



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class
        ]);
    }
}