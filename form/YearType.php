<?php

namespace ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class YearType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', ChoiceType::class, array('label'=>'Year',
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
                                                   'attr' =>array('class'=>'form-control')))                      
            ->add('Submit', SubmitType::class, array('label'=>'Edit',
                                                     'attr'=> array('class'=>'btn btn-success')))           
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array());
    }
}
