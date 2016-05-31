<?php
// src/BlogBundle/Form/UserLoginType.php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BlogBundle\Entity\User;
use BlogBundle\Entity;

class UserLoginType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', null, array('attr' => array('autofocus' => true, 'size' => '40'), 'label' => 'Your login: ' ))
            ->add('pass',  'Symfony\Component\Form\Extension\Core\Type\PasswordType', array('attr' => array('autofocus' => true, 'size' => '40'), 'label' => 'Password: ' ))
            ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'LogIn'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\User',
        ));
    }
}