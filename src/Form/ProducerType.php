<?php

namespace App\Form;

use App\Entity\Producer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProducerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Producer name',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30
                ]
            ])
            ->add('age', IntegerType::class,
            [
                'label' => 'Producer age',
                'attr' => [
                    'min' => 15,
                    'max' => 80
                ]
            ])
            ->add('address',TextType::class,
            [
                'label' => 'Producer address',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 50
                ]
            ])
            ->add('image' ,TextType::class,
            [
                'label' => 'Producer image',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producer::class,
        ]);
    }
}
