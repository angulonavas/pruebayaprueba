<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class ConceptoAdmin extends AbstractAdmin {
    
    protected $parentAssociationMapping = 'factura';

    // configuración de rutas
    protected function configureRoutes(RouteCollection $collection) {
        $collection->clearExcept(array('list'));
    }

    // método llamado automáticamente para dar valores por defecto a las nuevas entidades
    public function getNewInstance() {
        $instance = parent::getNewInstance();

        return $instance;
    }

    // método utilizado para mostrar el nombre de usuario en el breadcrums
    public function toString($object) {
        return 'Concepto';
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('descripcion')
            ->add('precio', 'currency', [
                'template' => ':Admin:formato_euro.html.twig',
                'campo' => 'precio'
            ])
            ->add('iva', 'currency', [
                'template' => ':Admin:formato_porcentaje.html.twig',
                'campo' => 'iva'
            ])                        
        ;
    }
}