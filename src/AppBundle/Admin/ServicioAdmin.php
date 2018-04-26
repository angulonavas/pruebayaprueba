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

class ServicioAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setPublicado(true);
        $instance->setPrioridad(2);

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Servicios del catálogo', ['class' => 'col-md-6'])
                ->add('publicado', CheckboxType::class, array('required' => false))
                ->add('titulo', TextType::class)
                ->add('descripcion', TextType::class)
                ->add('fechaIni', DateTimeType::class)
                ->add('fechaFin', DateTimeType::class)
                ->add('prioridad', ChoiceType::class, array(
                    'choices'  => array(
                        'Muy alta' => 0,
                        'Alta' => 1,
                        'Media' => 2,
                        'Baja' => 3,
                    ))
                )
                ->add('precio', TextType::class)
                ->add('iva', TextType::class)
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('publicado')
            ->add('titulo')
            ->add('descripcion')
            ->add('fechaIni')
            ->add('fechaFin')
            ->add('prioridad')
            ->add('precio')
            ->add('iva')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('publicado')
            ->addIdentifier('titulo')
            ->addIdentifier('descripcion')
            ->addIdentifier('fechaIni')
            ->addIdentifier('fechaFin')
            ->addIdentifier('prioridad')
            ->addIdentifier('precio')
            ->addIdentifier('iva')
        ;
    }
}