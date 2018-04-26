<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Asignatura;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TemarioAdmin extends AbstractAdmin {
    
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
                ->add('precio', TextType::class)
                ->add('iva', TextType::class)
                ->add('publicado', CheckboxType::class, array('required' => false))
                ->add('asignatura', EntityType::class, [
                    'class' => Asignatura::class,
                    'choice_label' => 'titulo',
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('titulo')
            ->add('descripcion')
            ->add('precio')
            ->add('iva')            
            ->add('publicado')
            ->add('asignatura.titulo')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('titulo')
            ->addIdentifier('descripcion')
            ->addIdentifier('precio')
            ->addIdentifier('iva')
            ->addIdentifier('publicado')
            ->addIdentifier('asignatura.titulo')
        ;
    }
}
