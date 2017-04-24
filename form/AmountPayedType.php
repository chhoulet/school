<?php

namespace ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AmountPayedType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payment', NumberType::class, array('label'=>'Amount :',
                                                      'attr'=>['class'=>'form-control']))                                                                  
            ->add('paymentMethod', ChoiceType::class, array('label'=>'Payment Method :',
                                                            'choices'=>['Cash'=>1,
                                                                        'Credit card'=>2,
                                                                        'Check'=>3],
                                                            'attr'=>['class'=>'form-control']))            
            ->add('Valid', SubmitType::class, array('attr'=>['class'=>'btn btn-success']))            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArticleBundle\Entity\AmountPayed'
        ));
    }
}
