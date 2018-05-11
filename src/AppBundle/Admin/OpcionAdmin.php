<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class OpcionAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        return $instance;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Opción';
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Anuncios para el tablón', ['class' => 'col-md-12'])
                ->add('orden', TextType::class)
                ->add('descripcion', TextType::class)
                ->add('cierta', CheckboxType::class, array('required' => false))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('descripcion')
            ->add('cierta');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('descripcion')
            ->addIdentifier('cierta');
    }
}