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
            ->add('paper',null,array('label' => 'Бумага'))
            ->add('printer',null,array('label' => 'Принтер','required'  => true))
            ->add('count',null,array('label' => 'Количество'))
            ->add('typePrint','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    '1' => 'Цвет 2 стороны',
                    '2' => 'Цвет 1 сторона',
                    '3' => 'ЧБ 2 сторона',
                    '4' => 'ЧБ 1 сторона',
                ),
                'label' => 'Тип печати',
                'required'  => false,
            ))
//            ->add('status','choice',  array(
//                'empty_value' => false,
//                'choices' => array(
//                    '0' => 'Зарезервированно',
//                    '1' => 'Потрачено',
//                ),
//                'label' => 'Статус бумаги',
//                'required'  => false,
//            ))
            ->add('submit', 'submit', array('label' => 'Сохранить'))
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
