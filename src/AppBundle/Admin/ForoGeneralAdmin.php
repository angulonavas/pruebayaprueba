<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ForoGeneralAdmin extends AbstractAdmin {
    
    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return $object->getDescripcion();
    }    

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Foros generales', ['class' => 'col-md-6'])
                ->add('orden', TextType::class)
                ->add('descripcion', TextType::class)
                ->add('url', TextType::class)
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('orden')
            ->add('descripcion')
            ->add('url')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('orden')
            ->addIdentifier('descripcion')
            ->add('url', 'url', [
                'template' => ':Admin:url_foro.html.twig'
            ])
        ;
    }
}