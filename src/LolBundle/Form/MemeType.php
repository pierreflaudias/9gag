<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 29/05/17
 * Time: 10:48.
 */

namespace LolBundle\Form;

use LolBundle\Entity\Meme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $label_class = ['class' => 'col-sm-2 control-label'];
        $input_class = ['class' => 'form-control'];
        $builder
            ->add('title', TextType::class, [
                'label_attr' => $label_class,
                'attr' => $input_class,
            ])
            ->add('image', FileType::class, [
                'label_attr' => $label_class,
                'attr' => $input_class,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Meme::class,
        ));
    }
}
