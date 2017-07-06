<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class LetterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('letter', TextType::class, array(
        'required' => true,
        'constraints' => array(
            new Length(array('min' => 1, 'max'=>1)),
            new Type('alpha')
        ))
                );
        
    }

    public function getBlockPrefix() {
        return 'appbundle_letter';
    }

}
