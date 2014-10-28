<?php

namespace Paper\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FrozenPaperType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paper',array('label' => 'Бумага'))
            ->add('count',array('label' => 'Количество'))
            ->add('status','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    '0' => 'Зарезервированно',
                    '1' => 'Потрачено',
                ),
                'label' => 'Статус бумаги',
                'required'  => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Paper\MainBundle\Entity\FrozenPaper'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'paper_mainbundle_frozenpaper';
    }
}
