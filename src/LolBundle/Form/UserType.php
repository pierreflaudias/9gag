<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 03/06/17
 * Time: 09:07
 */

namespace LolBundle\Form;

use LolBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $label_class = [ 'class' => 'col-sm-2 control-label' ];
        $input_class = [ 'class' => 'form-control' ];
        $builder
            ->add('email', EmailType::class, [
                'label_attr' => $label_class,
                'attr' => $input_class,
            ])
            ->add('username', TextType::class, [
                'label_attr' => $label_class,
                'attr' => $input_class,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [ 'label' => 'Password', 'label_attr' => $label_class, 'attr' => $input_class, ],
                'second_options' => [ 'label' => 'Repeat Password', 'label_attr' => $label_class, 'attr' => $input_class, ],

            ])
            ->add('save', SubmitType::class, [
                'attr' => [ 'class' => 'btn btn-success' ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}