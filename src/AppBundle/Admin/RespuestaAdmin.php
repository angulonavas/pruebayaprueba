<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RespuestaAdmin extends AbstractAdmin {
    
    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Respuesta';
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('descripcion', TextareaType::class, [ 
                'attr' => array('cols' => '100', 'rows' => '10') 
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('fecha')    
        ;        
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('fecha', null, [
                'format' => 'd-m-Y H:i'
            ])
        ;
    }
}