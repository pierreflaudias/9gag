<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 03/06/17
 * Time: 18:03
 */

namespace LolBundle\Form;


use LolBundle\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $label_class = [ 'class' => 'col-sm-2 control-label' ];
        $input_class = [ 'class' => 'form-control' ];
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Comment',
                'label_attr' => $label_class,
                'attr' => $input_class,
            ])
            ->add('save', SubmitType::class, [
                'attr' => [ 'class' => 'btn btn-success' ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Comment::class,
        ));
    }
}