<?php 

namespace SeguridadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('nombre', TextType::class)
            ->add('apellidos', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'La confirmación de la clave no coincide. Por favor, vuelve a introducirlas',
                'options' => array('attr' => array('class' => 'password-field', 'minlength' => 4, 'maxlength' => 8)),
                'required' => true,
                'first_options'  => array('label' => 'Clave'),
                'second_options' => array('label' => 'Confirmar clave'),
            ))
            ->add('universidad', TextType::class)
            ->add('registrarse', SubmitType::class, array('label' => 'Registrarse'))            
        ;
    }
}