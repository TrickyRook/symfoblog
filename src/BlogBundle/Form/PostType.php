<?php
// src/BlogBundle/Form/PostType.php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BlogBundle\Entity\BlogPost;
use BlogBundle\Entity;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', null, array('attr' => array('autofocus' => true, 'size' => '95'), 'label' => 'Caption: ' ))
            ->add('body', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array('label' => 'Text: ', 'attr' => array('rows' => '15', 'cols' => '100') ))
            ->add('Save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Save Post'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\BlogPost',
        ));
    }
}