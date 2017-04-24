<?php

namespace ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use ArticleBundle\Repository\AmountRepository;

class StudentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $yearSchool=$options['yearSchool'];

        $builder
            ->add('name', TextType::class, array('label'=>'Name :',
                                                 'attr'=>['class'=>'form-control']))
            ->add('firstname', TextType::class, array('label'=>'Firstname :',
                                                      'attr'=>['class'=>'form-control']))
            ->add('mail', TextType::class, array('label'=>'Email :',
                                                      'attr'=>['class'=>'form-control'],
                                                      'required'=>false))
            ->add('fix', TextType::class, array('label'=>'Land Line :',
                                                      'attr'=>['class'=>'form-control']))
            ->add('mobile', TextType::class, array('label'=>'Mobile :',
                                                      'attr'=>['class'=>'form-control']))
            ->add('birthdate', DateType::class, array('label'=>'BirthDate :',
                                                      'widget'=>'single_text',
                                                      'html5' =>false,
                                                      'attr'=>['class'=>'js-datepicker']))            
            ->add('address', TextType::class, array('label'=>'Address :',
                                                    'attr'=>['class'=>'form-control']))
            ->add('postCode', TextType::class, array('label'=>'Post Code :',
                                                     'attr'=>['class'=>'form-control']))
            ->add('city', TextType::class, array('label'=>'City :',
                                                 'attr'=>['class'=>'form-control']))
            ->add('amount', EntityType::class, array('label'=>'Scholar Year :',
                                                     'class'=>'ArticleBundle:Amount',
                                                     'choice_label'=>'scholarYear',                                                                     
                                                     'query_builder'=>function(AmountRepository $er) use($yearSchool)
                                                     {
                                                        return $er->getAmountsForStudentCreation($yearSchool);
                                                     },
                                                     'attr'=>['class'=>'form-control']
                                                     ))
            ->add('Valid', SubmitType::class, ['attr'=>['class'=>'btn btn-info']])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArticleBundle\Entity\Student'
        ));

         $resolver->setRequired(['yearSchool']);
    }
}
