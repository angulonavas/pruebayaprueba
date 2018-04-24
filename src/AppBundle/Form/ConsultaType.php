<?php 

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConsultaType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('descripcion', TextareaType::class, array(
            	'label' => false,
            	'attr' => array(
            		'class' => 'form-control',
            		'placeholder' => 'Envía tu consulta al profesor')
            ))
            ->add('enviar', SubmitType::class, array(
            	'label' => 'Enviar',
            	'attr' => array('class' => 'btn btn-primary')
            ))
        ;
    }
}