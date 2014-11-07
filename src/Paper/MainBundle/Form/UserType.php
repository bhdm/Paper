<?php

namespace Paper\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Логин'))
            ->add('password', 'repeated', array('type' => 'password', 'invalid_message' => 'пароли не совпадают', 'first_options'  => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Повторите пароль'),))

            ->add('userRoles','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    'ROLE_ADMIN' => 'Администратор',
                    'ROLE_MANAGER' => 'Менеджер',
                    'ROLE_PRESSMAN' => 'Печатник',
                ),
                'label' => 'Активность',
                'required'  => false,
            ))
            ->add('enabled','choice',  array(
                'empty_value' => false,
                'choices' => array(
                    '1' => 'Активен',
                    '0' => 'Заблокирован',
                ),
                'label' => 'Активность',
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
            'data_class' => 'Paper\MainBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'paper_mainbundle_user';
    }
}
