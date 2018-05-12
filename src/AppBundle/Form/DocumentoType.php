<?php 

namespace AppBundle\Form;

use AppBundle\Entity\Documento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentoType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
            ->add('descripcion', TextType::class, array(
            	'label' => 'Descripción',
				'attr' => array(
                	'class' => 'form-control',
                    'placeholder' => 'Indica con qué nombre quieres que aparezca el documento'
                )
            ))
            ->add('file', FileType::class, array(
                'label' => false,
                'attr' => array('class' => 'btn btn-primary btn-block')
            ))
            ->add('enviar', SubmitType::class, array(
            	'label' => 'Enviar',
            	'attr' => array('class' => 'btn btn-primary')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Documento::class,
        ));
    }    
}