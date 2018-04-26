<?php

namespace SeguridadBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UsuarioAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $instance->setIsactive(true);

        return $instance;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Anuncios para el tablón', ['class' => 'col-md-6'])
                ->add('username', TextType::class)
                ->add('email', TextType::class)
                ->add('rol', ChoiceType::class, array(
                    'choices'  => array(
                        'ROLE_ANONIMO' => 'ROLE_ANONIMO',
                        'ROLE_ALUMNO' => 'ROLE_ALUMNO',
                        'ROLE_PROFESOR' => 'ROLE_PROFESOR',
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                    ))
                )
                ->add('nombre', TextType::class)
                ->add('apellidos', TextType::class)
                ->add('isActive', CheckboxType::class, array('required' => false))
                ->add('universidad', TextType::class)
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('rol')
            ->add('nombre')
            ->add('apellidos')
            ->add('isActive')
            ->add('universidad')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('username')
            ->addIdentifier('email')
            ->addIdentifier('rol')
            ->addIdentifier('nombre')
            ->addIdentifier('apellidos')
            ->addIdentifier('isActive')
            ->addIdentifier('universidad')
        ;
    }
}