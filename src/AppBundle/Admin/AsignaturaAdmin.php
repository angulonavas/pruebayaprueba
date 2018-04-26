<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AsignaturaAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Anuncios para el tablón', ['class' => 'col-md-6'])
                ->add('orden', TextType::class)
                ->add('titulo', TextType::class)
                ->add('descripcion', TextType::class)
                ->add('logo', TextType::class)
                ->add('disenyo', TextType::class)
                ->add('publicado', CheckboxType::class, array('required' => false))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('titulo')
            ->add('descripcion')
            ->add('logo')
            ->add('disenyo')            
            ->add('publicado')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('titulo')
            ->addIdentifier('descripcion')
            ->addIdentifier('logo')
            ->addIdentifier('disenyo')
            ->addIdentifier('publicado');
    }
}
