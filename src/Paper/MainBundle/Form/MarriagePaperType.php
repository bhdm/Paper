<?php

namespace Paper\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MarriagePaperType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paper', null, array('label' => 'Бумага'))
            ->add('count', null, array('label' => 'Количество'))
            ->add('typePrint','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    '1' => '4+4',
                    '2' => '4+0',
                    '3' => '1+1',
                    '4' => '1+0',
                    '5' => '4+1',
                    '6' => '0+0',
                ),
                'label' => 'Тип печати',
                'required'  => false,
            ))
            ->add('submit', 'submit', array('label' => 'Сохранить'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Paper\MainBundle\Entity\MarriagePaper'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'paper_mainbundle_marriagepaper';
    }
}
