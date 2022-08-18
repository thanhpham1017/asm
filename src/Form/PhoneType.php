<?php

namespace App\Form;

use App\Entity\Phone;
use App\Entity\Color;
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
            /* 
            Thông tin chứa dữ liệu của bảng khác trong DB
            => Load dữ liệu của bảng Producer và Color trong 
            form add/edit Phone để người dùng lựa chọn
            */
            ->add('producers', EntityType::class,
            [
                'label' => 'Producer',
                'required' => true,
                'class' => Producer::class,
                'choice_label' => 'name',
                'multiple' => true,  //nếu có thể chọn nhiều option (relationship: many)
                'expanded' => false
            ]) 
            ->add('color', EntityType::class,
            [
                'label' => 'Color',
                'required' => true,
                'class' => Color::class,
                'choice_label' => 'name',
                'multiple' => false, //nếu chỉ được chọn 1 option (relationship: 1)
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
