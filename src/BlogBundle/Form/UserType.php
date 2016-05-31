<?php
// src/BlogBundle/Form/UserType.php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use BlogBundle\Entity\User;
use BlogBundle\Entity;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class) #null, array('attr' => array('autofocus' => true, 'size' => '40'), 'label' => 'Your login: ' ))
            #->add('pass',  'Symfony\Component\Form\Extension\Core\Type\PasswordType', array('attr' => array('autofocus' => true, 'size' => '40'), 'label' => 'Password: ' ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('email', EmailType::class) # null, array('attr' => array('autofocus' => true, 'size' => '40'), 'label' => 'Email: ' ))
            #->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Register'))
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