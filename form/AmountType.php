<?php

namespace ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AmountType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amountToBePayed', NumberType::class, array('label'=>'School year Cost :',
                                                              'attr'=>['class'=>'form-control']))
            ->add('examFees', NumberType::class,        array('label'=>'Exams fees :',
                                                              'attr'=>['class'=>'form-control']))
            ->add('scholarYear', TextType::class,       array('label'=>'School year  :',
                                                              'attr'=>['class'=>'form-control']))
            ->add('civilYear', ChoiceType::class,       array('label'=>'Civil year :',
                                                              'choices'=>['2017-2018'=>'2017-2018',
                                                                          '2018-2019'=>'2018-2019',
                                                                          '2019-2020'=>'2019-2020',
                                                                          '2020-2021'=>'2020-2021',
                                                                          '2021-2022'=>'2021-2022',
                                                                          '2022-2023'=>'2022-2023',
                                                                          '2023-2024'=>'2023-2024',
                                                                          '2024-2025'=>'2024-2025',
                                                                          '2025-2026'=>'2025-2026',
                                                                          '2026-2027'=>'2026-2027',
                                                                          '2027-2028'=>'2027-2028',
                                                                          '2028-2029'=>'2028-2029',
                                                                          '2029-2030'=>'2029-2030',
                                                                          '2030-2031'=>'2030-2031',
                                                                          '2031-2032'=>'2031-2032',
                                                                          '2032-2033'=>'2032-2033',
                                                                          '2033-2034'=>'2033-2034',
                                                                          '2034-2035'=>'2034-2035',
                                                                          '2035-2036'=>'2035-2036'],
                                                              'attr'=>['class'=>'form-control']))
            ->add('Valid', SubmitType::class,           array('attr'=>['class'=>'btn btn-info']))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArticleBundle\Entity\Amount'
        ));
    }
}

