<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class WordGuessType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('word', TextType::class, array(
        'required' => true,
        'constraints' => array(
            new Length(array('min' => 5)),
            new Type('alpha')
        ))
                );
        
    }

    public function getBlockPrefix() {
        return 'appbundle_word';
    }

}
