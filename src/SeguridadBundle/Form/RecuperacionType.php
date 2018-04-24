<?php 

namespace SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecuperacionType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'La confirmación de la clave no coincide. Por favor, vuelve a introducirlas',
                'options' => array('attr' => array('class' => 'password-field', 'minlength' => 4, 'maxlength' => 8)),
                'required' => true,
                'first_options'  => array(
                    'label' => 'Clave', 
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Clave'
                    )
                ),
                'second_options' => array(
                    'label' => 'Confirmar clave', 
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Confirmar clave'                        
                    )
                ),
            ))
            ->add('recuperar', SubmitType::class, array(
                'label' => 'Confirmar',
                'attr' => array('class' => 'btn btn-primary')
            ))
        ;
    }
}