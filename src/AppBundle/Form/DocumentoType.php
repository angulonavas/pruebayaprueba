<?php 

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DocumentoType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('descripcion', TextType::class, array('label' => 'Descripción'))
            ->add('attachment', FileType::class)
            ->add('Enviar', SubmitType::class, array('label' => 'Enviar'))            
        ;
    }
}