<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Phone;
use App\Entity\Store;
use App\Entity\Producer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
            [
                'label' => 'Phone title',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30
                ]
            ])
            ->add('quantity', IntegerType::class,
            [
                'label' => 'Phone quantity',
                'attr' => [
                    'min' => 1,
                    'max' => 100
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'label' => 'Phone price',
                'currency' => 'USD'
            ])
            ->add('date', DateType::class,
            [
                'label' => 'Published date',
                'widget' => 'single_text'
            ])
            ->add('image' ,TextType::class,
            [
                'label' => 'Phone image',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            
            ->add('producers', EntityType::class,
            [
                'label' => 'Producer',
                'required' => true,
                'class' => Producer::class,
                'choice_label' => 'name',
                'multiple' => true, 
                'expanded' => false
            ]) 
            ->add('color', EntityType::class,
            [
                'label' => 'Color',
                'required' => true,
                'class' => Color::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false
            ])
            ->add('store', EntityType::class,
            [
                'label' => 'Store',
                'required' => true,
                'class' => Store::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false
            ])
            /* Note:
                multiple: false & expanded: false => drop-down list
                multiple: false & expanded: true => radio button
                multiple: true & expanded: false => drop-down list   (Hold CTRL button to select many)
                multiple: true & expanded: true => check-box    
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Phone::class,
        ]);
    }
}
